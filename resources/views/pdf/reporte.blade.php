<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de ventas</title>

    <link rel="stylesheet" href="{{ asset('css/custom_pdf.css') }}">
</head>
<body>

    <section style="top: -287px;">
        <table cellpadding="0" cellspacing="0" whidth="100%">
            <tr>
                <td colspan="2" class="text-center">
                    <span style="font-size: 25px; font-weight: bold;">Sistema J & Y</span>
                </td>
            </tr>
            <tr>
                <td width="70%" style="vertical-align: top; padding-top: 10px;">
                    @if ($type == 0)
                        <span style="font-size: 16px;">Reporte del ventas del Día</span>
                    @else
                        <span style="font-size: 16px;">Reporte del ventas por Fecha</span>
                    @endif
                    <br>
                    @if ($type != 0)
                        <span style="font-size: 16px;"><strong>Fecha de Consulta : {{ $fromDate }} al {{ $toDate }}</strong></span>
                    @else
                        <span style="font-size: 16px;"><strong>Fecha de Consulta : {{ \Carbon\Carbon::now()->format('d-m-Y') }}</strong></span>
                    @endif
                    <br>
                    <span style="font-size: 14px;">Usuario: {{ $user }}</span>
                </td>
            </tr>
        </table>
    </section>

    <section style="top: -110px;">

        <table cellpadding="0" cellspacing="0" whidth="100%">
            <thead>
                <tr>
                    <th width="10%">Folio</th>
                    <th width="12%">Importe</th>
                    <th width="10%">Items</th>
                    <th width="12%">Estatus</th>
                    <th>Usuario</th>
                    <th width="18%">Fecha</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td align="center">{{ $item->id }}</td>
                        <td align="center">${{ number_format($item->total,2) }}</td>
                        <td align="center">{{ $item->items }}</td>
                        <td align="center">{{ $item->status }}</td>
                        <td align="center">{{ $item->user }}</td>
                        <td align="center">{{ $item->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td class="text-center">
                        <span><b>Total</b></span>
                    </td>
                    <td colspan="1" class="text-center">
                        <span><strong>${{ number_format($data->sum('total'),2) }}</strong></span>
                    </td>
                    <td class="text-center">
                        {{ $data->sum('items') }}
                    </td>
                    <td colspan="3"></td>
                </tr>
            </tfoot>
        </table>

    </section>

    <section class="footer">
        <table cellpadding="0" cellspacing="0" whidth="100%">
            <tr>
                <td width="20%">
                    sistema J & Y v1
                </td>
                <td width="60%" class="text-center">
                    jaiverramos.com
                </td>
                <td width="20%" class="text-center">
                    pagina
                </td>
            </tr>
        </table>    
    </section>
    
</body>
</html>