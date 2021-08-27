<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Sales;
use Carbon\Carbon;

class Cashout extends Component
{
    public $fromDate, $toDate, $userid, $total, $items, $sales, $details;

    public function mount()
    {
        $this->fromDate = null;
        $this->toDate = null;
        $this->userid = 0;
        $this->total = 0;
        $this->sales = [];
        $this->details = [];
    }

    public function render()
    {
        $users = User::orderBy('name', 'asc')->get();

        return view('livewire.cashout.cashout', compact('users'))
            ->extends('adminlte::page')
            ->section('content');
    }

    public function consultar()
    {
        $fi = Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00';
        $ff = Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59';

        $this->sales = Sales::wherebetween('created_at', [$fi, $ff])
                    ->where('status', 'PAID')
                    ->where('user_id', $this->userid)
                    ->get();

        $this->total = $this->sales ? $this->sales->sum('total') : 0;
        $this->items = $this->sales ? $this->sales->sum('items') : 0;
    }

    public function viewDetail(Sales $sale)
    {
        $fi = Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00';
        $ff = Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59';

        $this->details = Sales::join('sales_details as d', 'd.sale_id', 'sales.id')
                            ->join('products as p', 'p.id', 'd.product_id')
                            ->select('d.sale_id', 'p.name as product', 'd.quantity', 'd.price')
                            ->wherebetween('sales.created_at', [$fi, $ff])
                            ->where('sales.status', 'PAID')
                            ->where('sales.user_id', $this->userid)
                            ->where('sales.id', $sale->id)
                            ->get();

        $this->emit('show-modal', 'open modal');
    }

    public function print()
    {
        
    }
}
