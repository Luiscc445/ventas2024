<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Denomination;

use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Denominations extends Component
{

    use WithFileUploads;
    use WithPagination;

    public $componentName, $pageTitle, $search, $type, $value, $selected_id;
    private $pagination = 5;

    protected $listeners = [
        'deleteRow' => 'destroy'
    ];

    public function mount()
    {
        $this->componentName = 'Denominaciones';
        $this->pageTitle = 'Listado';
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        if (strlen($this->search) > 0)
            $data = Denomination::where('type', 'like', '%' . $this->search . '%')
                    ->orWhere('value', 'like', '%' . $this->search . '%')
                    ->paginate($this->pagination);
        else
            $data = Denomination::orderBy('type', 'desc')->paginate($this->pagination);

        return view('livewire.denomination.denominations', ['denominations' => $data])
                ->extends('adminlte::page')
                ->section('content');
    }

    public function resetUI()
    {
        $this->type = 'Elegir';
        $this->value = '';
        $this->selected_id = 0;

        $this->emit('cancel', 'cancelar');
    }

    public function save()
    {
        $rules = [
            'type' => 'required',
            'value' => 'required'
        ];

        $messages = [
            'type.required' => 'el tipo es requerido',
            'value.required' => 'el valor es requerido'
        ];

        $this->validate($rules, $messages);

        $denomination = Denomination::create([
            'type' => $this->type,
            'value' => $this->value
        ]);

        $this->resetUI();
        $this->emit('denomination-added', 'denominacion guardada');
    }

    public function edit(Denomination $denomination)
    {
        $this->selected_id = $denomination->id;
        $this->type = $denomination->type;
        $this->value = $denomination->value;

        $this->emit('show-modal', 'modal editar');
    }

    public function update()
    {
        $rules = [
            'type' => 'required',
            'value' => 'required'
        ];

        $messages = [
            'type.required' => 'el tipo es requerido',
            'value.required' => 'el valor es requerido'
        ];

        $this->validate($rules, $messages);

        $denomination = Denomination::find($this->selected_id);

        $denomination->update([
            'type' => $this->type,
            'value' => $this->value
        ]);

        $this->resetUI();
        $this->emit('denomination-updated', 'denominacion Actualizada');
    }

    public function destroy(Denomination $denomination)
    {
        $denomination->delete();

        $this->resetUI();
        $this->emit('denomination-delete', 'Categoria eliminada');
    }
}
