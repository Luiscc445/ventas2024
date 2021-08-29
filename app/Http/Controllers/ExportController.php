<?php

namespace App\Http\Controllers;

use App\Exports\SalesExport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use App\Models\Sales;
use App\Models\SalesDetails;
use App\Models\User;

class ExportController extends Controller
{
    public function reportPDF($userId, $type, $fromDate = null, $toDate = null)
    {
        $data = [];

        if($type == 0)
        {
            $from = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse(Carbon::now())->format('Y-m-d')   . ' 23:59:59';
        } else {
            $from = Carbon::parse($fromDate)->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse($toDate)->format('Y-m-d')     . ' 23:59:59';
        }

        if($userId == 0)
        {
            $data = Sales::join('users as u', 'u.id', 'sales.user_id')
            ->select('sales.*', 'u.name as user')
            ->whereBetween('sales.created_at', [$from, $to])
            ->get(); 
            
        } else {
            $data = Sales::join('users as u', 'u.id', 'sales.user_id')
                        ->select('sales.*', 'u.name as user')
                        ->wherebetween('sales.created_at', [$from, $to])
                        ->where('sales.user_id', $userId)
                        ->get(); 
        }

        $user = $userId == 0 ? 'Todos' : User::find($userId)->name;

        $pdf = PDF::loadView('pdf.reporte', compact('data', 'type', 'user', 'fromDate', 'toDate'));
        return $pdf->stream('salesReport.pdf');
    }

    public function reportExcel($userId, $type, $fromDate = null, $toDate = null)
    {
        $reportName = 'Reporte de Ventas_' . uniqid() . 'xlsx';
        return Excel::download(new SalesExport($userId, $type,$fromDate, $toDate), $reportName);
    }
}
