<?php

namespace App\Exports;

use App\Models\Sales;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class SalesExport implements FromCollection, WithHeadings,WithProperties, WithCustomStartCell, WithTitle, WithStyles
{
    
    protected $userId, $type, $fromDate, $toDate;

    function __construct($userId, $type, $f1, $f2)
    {
        $this->userId = $userId;
        $this->type = $type;
        $this->fromDate = $f1;
        $this->toDate = $f2;
    }

    public function collection()
    {
        $data = [];

        if($this->type == 1 )
        {
            $from = Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse($this->toDate)->format('Y-m-d')     . ' 23:59:59';
        } else {
            $from = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse(Carbon::now())->format('Y-m-d')   . ' 23:59:59';
        }

        if($this->userId == 0)
        {
            $data = Sales::join('users as u', 'u.id', 'sales.user_id')
            ->select('sales.*', 'u.name as user')
            ->whereBetween('sales.created_at', [$from, $to])
            ->get(); 
            
        } else {
            $data = Sales::join('users as u', 'u.id', 'sales.user_id')
                        ->select('sales.*', 'u.name as user')
                        ->wherebetween('sales.created_at', [$from, $to])
                        ->where('sales.user_id', $this->userId)
                        ->get(); 
        }

        return $data;
    }

    public function headings(): array
    {
        return ["Folio", "Importe", "Items", "Estatus", "Usuario", "Fecha"];
    }

    public function startCell(): string
    {
        return 'A2';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            2 => ['font' => ['bold' => true]],
        ];
    }

    public function title() : string
    {
        return 'Reporte de ventas';
    }

    public function properties(): array
    {
        return [
            'title' => 'Reporte de ventas',
        ];
    }

}
