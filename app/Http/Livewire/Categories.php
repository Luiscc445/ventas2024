<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Categories extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $name, $image, $search, $selected_id, $pageTitle, $componentName;
    private $pagination = 5;

    protected $listeners = [
        'deleteRow' => 'destroy'
    ];

    public function mount()
    {
        $this->componentName = 'Categorias';
        $this->pageTitle = 'Listado';
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        if (strlen($this->search) > 0)
            $data = Category::where('name', 'like', '%' . $this->search . '%')
                    ->paginate($this->pagination);
        else
            $data = Category::orderBy('id', 'desc')->paginate($this->pagination);
            
        

        return view('livewire.category.categories', ['categories' => $data])
            ->extends('adminlte::page')
            ->section('content');
    }

    public function resetUI()
    {
        $this->name = '';
        $this->image = null;
        $this->selected_id = 0;

        $this->emit('cancel', 'cancelar');
    }

    public function edit($id)
    {
        $record = Category::find($id, ['id', 'name', 'image']);

        $this->selected_id = $record->id;
        $this->name = $record->name;
        $this->image = null;

        $this->emit('show-modal', 'edit');
    }

    public function save()
    {
        $rules = [
            'name' => 'required|unique:categories'
        ];

        $messages = [
            'name.required' => 'Nombre de la categoria es requerido',
            'name.unique' => 'El nombre de la categoria ya existe'
        ];

        $this->validate($rules, $messages);

        $category = Category::create([
            'name' => $this->name
        ]);

        
        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/categories', $customFileName);

            $category->image = $customFileName;
            $category->save();

        }

        $this->resetUI();
        $this->emit('cateory-added', 'Categoria guardada');
    }

    public function update()
    {
        $rules = [
            'name' => "required|unique:categories,name,{$this->selected_id}"
        ];

        $messages = [
            'name.required' => 'Nombre de la categoria es requerido',
            'name.unique' => 'El nombre de la categoria ya existe'
        ];

        $this->validate($rules, $messages);

        $category = Category::find($this->selected_id);
        $category->update([
            'name' => $this->name
        ]);

        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/categories', $customFileName);

            $imageName = $category->image;

            $category->image = $customFileName;
            $category->save();

            if ($imageName != null) {
                if (file_exists('public/categories/' . $imageName)) {
                    unlink('public/categories/' . $imageName);
                }
            }
        }

        $this->resetUI();
        $this->emit('category-updated', 'Categoria Actualizada');

    }


    public function destroy(Category $category)
    {
        $imageName = $category->image;
        $category->delete();

        if ($imageName != null) {
            unlink('storage/categories/' . $imageName);
        }

        $this->resetUI();
        $this->emit('category-delete', 'Categoria eliminada');
    }
}
