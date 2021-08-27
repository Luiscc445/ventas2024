<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Sales;
use App\Models\SalesDetails;
use Carbon\Carbon;

class Reports extends Component
{
    public $componentName, $details, $saleId, $userId, $fromDate, $toDate, $reportType, $data, $countDetails, $sumDetails;

    public function mount()
    {
        $this->componentName = 'Reportes de Ventas';
        $this->data = [];
        $this->details = [];
        $this->sumDetails = 0;
        $this->countDetails = 0;
        $this->reportType = 0;
        $this->userId = 0;
        $this->saleId = 0;
    }

    public function render()
    {
        $this->salesByDate();

        $users = User::orderBy('name', 'asc')->get();

        return view('livewire.report.reports', compact('users'))
            ->extends('adminlte::page')
            ->section('content');
    }

    public function salesByDate()
    {
        if($this->reportType == 0)
        {
            $from = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse(Carbon::now())->format('Y-m-d')   . ' 23:59:59';
        } else {
            $from = Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse($this->toDate)->format('Y-m-d')     . ' 23:59:59';
        }

        if($this->reportType == 1 && ($this->fromDate == '' || $this->toDate == ''))
        {
            return;
        }

        if($this->userId == 0)
        {
            $this->data = Sales::join('users as u', 'u.id', 'sales.user_id')
                        ->select('sales.*', 'u.name as user')
                        ->whereBetween('sales.created_at', [$from, $to])
                        ->get(); 
        } else {
            $this->data = Sales::join('users as u', 'u.id', 'sales.user_id')
                        ->select('sales.*', 'u.name as user')
                        ->whereBetween('sales.created_at', [$from, $to])
                        ->where('sales.user_id', $this->userId)
                        ->get(); 
        }
    }

    public function getDetails($saleId)
    {
        $this->details = SalesDetails::join('products as p', 'p.id', 'sales_details.product_id')
                        ->select('sales_details.id', 'sales_details.price', 'sales_details.quantity', 'p.name as product')
                        ->where('sales_details.sale_id' , $saleId)
                        ->get();
        
        $suma = $this->details->sum(function($item){
            return $item->price * $item->quantity;
        });

        $this->sumDetails = $suma;
        $this->countDetails = $this->details->sum('quantity');
        $this->saleId = $saleId;

        $this->emit('show-modal', 'detalles cargados');
    }
}
