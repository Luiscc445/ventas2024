<?php

namespace App\Http\Livewire;

use App\Models\Denomination;
use App\Models\Product;
use App\Models\Sales;
use App\Models\SalesDetails;
use Darryldecode\Cart\Facades\CartFacade as Cart;

use Illuminate\Support\Facades\DB;
use Livewire\Component;


class Pos extends Component
{
    public $efectivo, $change, $total, $itemsQuantity;

    public function mount()
    {
        $this->efectivo = 0;
        $this->change = 0;
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
    }

    public function render()
    {
        $denominations = Denomination::orderBy('value', 'desc')->get();

        //Esto es del paquete que se instalo
        $cart = Cart::getContent()->sortBy('name');

        return view('livewire.pos.pos', compact('denominations', 'cart'))
                ->extends('adminlte::page')
                ->section('content');
    }

    public function Acash($value)
    {
        
        $this->efectivo =+ ($value == 0 ? $this->total : $value);
        $this->change = ($this->efectivo - $this->total);
        //dd($this->change);
    }

    protected $listeners = [
        'scan-code' => 'ScanCode',
        'remuveItem' => 'remuveItem',
        'clearCart' => 'clearCart',
        'saveSale' => 'saveSale',
    ];

    public function ScanCode($barcode, $cant = 1)
    {     
        $product = Product::where('barcode', $barcode)->first();
        

        if ($product == null || empty($product))
        {
            $this->emit('scan-notfound', 'El producto no esta registrado');
        }
        else
        {
            if ($this->inCart($product->id)) 
            {
                $this->incrementQuantity($product->id);
                return;
            }

            if ($product->stock < 1)
            {
                $this->emit('no-stock', 'Stock insuficiente :/ ');
                return;
            }

            Cart::add($product->id, $product->name, $product->price, $cant, $product->image);
            $this->total = Cart::getTotal();

            $this->emit('scan-ok', 'Producto agregado');
        }
    }

    public function inCart($productId)
    {
        $exist = Cart::get($productId);

        if ($exist)
            return true;
        else
            return false;

    }

    public function incrementQuantity($productId, $cant = 1)
    {
        $title = '';
        $product = Product::find($productId);
        $exist = Cart::get($productId);

        if ($exist)
            $title = 'Producto actualizado';
        else   
            $title = 'Producto registrado';

        if ($exist)
        {
            if ($product->stock < ($cant + $exist->quantity))
            {
                $this->emit('no-stock', 'Stock insuficiente :/ ');
                return;
            }
        }

        //dd($cant);

        Cart::add($product->id, $product->name, $product->price, $cant, $product->image);

        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();

        $this->emit('scan-ok', $title);
    }

    public function updateQty($productId, $cant = 1)
    {
        $title = '';
        $product = Product::find($productId);
        $exist = Cart::get($productId);

        if ($exist)
            $title = 'Producto actualizado';
        else   
            $title = 'Producto registrado';

        if ($exist)
        {
            if ($product->stock < $cant)
            {
                $this->emit('no-stock', 'Stock insuficiente :/ ');
                return;
            }
        }

        $this->remuveItem($product->id);

        if ($cant > 0)
        {
            Cart::add($product->id, $product->name, $product->price, $cant, $product->image);

            $this->total = Cart::getTotal();
            $this->itemsQuantity = Cart::getTotalQuantity();

            $this->emit('scan-ok', $title);
        }
    }

    public function remuveItem($productId)
    {
        Cart::remove($productId);

        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();

        $this->emit('scan-ok', 'Producto eliminado');
    }

    public function decrementQuantity($productId)
    {
        $item = Cart::get($productId);
        Cart::remove($productId);

        $newQty = ($item->quantity) - 1;

        if ($newQty > 0)
            Cart::add($item->id, $item->name, $item->price, $newQty, $item->attributes[0]);

        
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();

        $this->emit('scan-ok', 'Cantidad actualizada');

    }

    public function clearCart()
    {
        Cart::clear();
        $this->efectivo = 0;
        $this->change = 0;

        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();

        $this->emit('scan-ok', 'Carrito vacio');
    }

    public function saveSale()
    {
        
        if ($this->total <= 0) {
            $this->emit('sale-error', 'Agrega productos a la venta');
            return;
        }

        if ($this->efectivo <= 0) {
            $this->emit('sale-error', 'Ingrese el efectivo');
            return;
        }

        if ($this->total > $this->efectivo) {
            $this->emit('sale-error', 'El efectivo debe de ser mayor o igual a total');
            return;
        }
        
        DB::beginTransaction();

        try {
            
            $sale = Sales::create([
                'total' => $this->total,
                'items' => $this->itemsQuantity,
                'cash' => $this->efectivo,
                'change' => $this->change,
                'status' => 'PAID',
                'user_id' => '1', //Auth()->user->id 
            ]);

            if ($sale)
            {
                $items = Cart::getContent();

                foreach ($items as $item) {
                    SalesDetails::create([
                        'price' => $item->price,
                        'quantity' => $item->quantity,
                        'product_id' => $item->id,
                        'sale_id' => $sale->id,
                    ]);

                    //Update stock
                    $product = Product::find($item->id);
                    $product->stock = $product->stock - $item->quantity;
                    $product->save();
                }
            }

            DB::commit();

            Cart::clear();
            $this->efectivo = 0;
            $this->change = 0;

            $this->total = Cart::getTotal();
            $this->itemsQuantity = Cart::getTotalQuantity();

            $this->emit('sale-ok', 'Venta registrada con exito');
            $this->emit('print-ticket', $sale->id);

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            $this->emit('sale-error', $th->getMessage());
        }
    }

    public function printTicket($sale)
    {
        return Redirect::to("print://$sale->id");
    }

}
