<?php

namespace App\Http\Livewire;

use App\Models\Category;
use Livewire\Component;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Products extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $componentName, $pageName, $search, $selected_id, $name, $barcode, $cost, $price, $stock, $alert, $image, $categoryid;
    private $pagination = 5;

    protected $listeners = [
        'deleteRow' => 'destroy'
    ];

    public function mount()
    {
        $this->componentName = 'Productos';
        $this->pageName = 'Listado';
        $this->categoryid = 'Elegir';
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        if($this->search > 0)
            $products = Product::join('categories as c', 'c.id', 'products.category_id')
                        ->select('products.*', 'c.name as category')
                        ->where('product.name', 'like', '%' . $this->search . '%')
                        ->orWhere('product.barcode', 'like', '%' . $this->search . '%')
                        ->orWhere('category', 'like', '%' . $this->search . '%')
                        ->orderBy('products.name', 'asc')
                        ->paginate($this->pagination);
        else
            $products = Product::join('categories as c', 'c.id', 'products.category_id')
                        ->select('products.*', 'c.name as category')
                        ->orderBy('products.name', 'asc')
                        ->paginate($this->pagination);



        $categories = Category::orderBy('name', 'asc')->get();

        return view('livewire.product.products', compact('products', 'categories'))
                ->extends('adminlte::page')
                ->section('content');
    }

    public function resetUI()
    {
        $this->selected_id = 0;
        $this->name = '';
        $this->barcode = '';
        $this->cost = '';
        $this->price = '';
        $this->stock = '';
        $this->alert = '';
        $this->image = '';
        $this->categoryid = 'Elegir';

        $this->emit('cancel', 'cancelar');
    }

    public function save()
    {
        $rules = [
            'name' => 'required|unique:products',
            'barcode' => 'required',
            'cost' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'alert' => 'required',
            'categoryid' => 'required|not_in:Elegir'
        ];

        $messages = [
            'name.required' => 'Nombre requiredo',
            'name.unique' => 'Nombre ya existe',
            'barcode.required' => 'Código requiredo',
            'cost.required' => 'Costo requiredo',
            'price.required' => 'Precio requiredo',
            'stock.required' => 'Stock requiredo',
            'alert.required' => 'Alerta requiredo',
            'categoryid.required' => 'Debe elegir una categoria',
            'categoryid.not_in' => 'Elija un nombre difirenete a Elegir',
        ];

        $this->validate($rules, $messages);

        $product = Product::create([
            'name' => $this->name,
            'barcode' => $this->barcode,
            'cost' => $this->cost,
            'price' => $this->price,
            'stock' => $this->stock,
            'alert' => $this->alert,
            'category_id' => $this->categoryid,
        ]);

        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/products', $customFileName);

            $product->image = $customFileName;
            $product->save();
        }

        $this->resetUI();
        $this->emit('product-added', 'Producto agregado');
    }

    public function edit(Product $product)
    {
        $this->selected_id = $product->id;
        $this->name = $product->name;
        $this->barcode = $product->barcode;
        $this->cost = $product->cost;
        $this->price = $product->price;
        $this->stock = $product->stock;
        $this->alert = $product->alert;
        $this->categoryid = $product->category_id;
        $this->image = null;

        $this->emit('show-modal', 'Modal Editar');
    }

    public function update()
    {
        $rules = [
            'name' => "required|unique:products,name,{$this->selected_id}",
            'barcode' => 'required',
            'cost' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'alert' => 'required',
            'categoryid' => 'required|not_in:Elegir'
        ];

        $messages = [
            'name.required' => 'Nombre requiredo',
            'name.unique' => 'Nombre ya existe',
            'barcode.required' => 'Código requiredo',
            'cost.required' => 'Costo requiredo',
            'price.required' => 'Precio requiredo',
            'stock.required' => 'Stock requiredo',
            'alert.required' => 'Alerta requiredo',
            'categoryid.required' => 'Debe elegir una categoria',
            'categoryid.not_in' => 'Elija un nombre difirenete a Elegir',
        ];

        $this->validate($rules, $messages);

        $product = Product::find($this->selected_id);

        $product->update([
            'name' => $this->name,
            'barcode' => $this->barcode,
            'cost' => $this->cost,
            'price' => $this->price,
            'stock' => $this->stock,
            'alert' => $this->alert,
            'category_id' => $this->categoryid,
        ]);

        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/products', $customFileName);

            $imageName = $product->image;

            $product->image = $customFileName;
            $product->save();

            if ($imageName != null) {
                if (file_exists('public/products/' . $imageName)) {
                    unlink('public/products/' . $imageName);
                }
            }
        }

        $this->resetUI();
        $this->emit('product-updated', 'Producto actualizado');
    }

    public function destroy(Product $product)
    {
        $imageName = $product->image;
        $product->delete();

        if ($imageName != null) {
            unlink('storage/products/' . $imageName);
        }

        $this->resetUI();
        $this->emit('product-deleted', 'Producto eliminada');
    }

}
