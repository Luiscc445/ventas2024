<div wire:ignore.self class="modal fade" id="modal-details" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>Detalle de la venta</b>
                </h5>
                <button class="close" data-dismiss="modal" type="button" aria-label="Close">
                    <span class="text-white">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mt-1">
                        <thead class="text-white bg-dark">
                            <tr>
                                <th class="table-th text-center text-white">Producto</th>
                                <th class="table-th text-center text-white">Cant</th>
                                <th class="table-th text-center text-white">Precio</th>
                                <th class="table-th text-center text-white">Importe</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($details as $item)
                                <tr>
                                    <td class="text-cener"><h6>{{ $item->product }}</h6></td>
                                    <td class="text-cener"><h6>{{ $item->quantity }}</h6></td>
                                    <td class="text-cener"><h6>${{ number_format($item->price,2) }}</h6></td>
                                    <td class="text-cener"><h6>${{ number_format($item->quantity * $item->price,2) }}</h6></td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <td class="text-right"><h6 class="text-info">TOTALES</h6></td>

                            <td class="text-center">
                                @if ($details)
                                    <h6 class="text-info">{{ $details->sum('quantity') }}</h6>
                                @endif
                            </td>

                            @if ($details)
                                @php
                                    $mytotal = 0;
                                @endphp
                                @foreach ($details as $item)
                                    @php
                                        $mytotal += $item->quantity * $item->price;
                                    @endphp
                                @endforeach
                                <td></td>
                                <td class="text-center"><h6 class="text-info">${{ number_format($mytotal,2) }}</h6></td>
                            @endif

                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
  </div>