<div wire:ignore.self class="modal fade" id="theModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-dark">
            <h5 class="modal-title text-white">
              <b>Detalle de venta #{{$saleId}}</b>
            </h5>
            <h6 class="text-center text-warning" wire:loading>Por favor espere...</h6>
          
        </div>
        <div class="modal-body">

            <div class="table-responsive">
                <table class="table table-bordered table-striped mt-1">

                    <thead class="text-white bg-dark">
                        <tr>
                            <th class="table-th text-white text-center">Folio</th>
                            <th class="table-th text-white text-center">Producto</th>
                            <th class="table-th text-white text-center">Precio</th>
                            <th class="table-th text-white text-center">Cant</th>
                            <th class="table-th text-white text-center">Importe</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($details as $item)
                            <tr>
                                <td class="text-center"><h6>{{ $item->id }}</h6></td>
                                <td class="text-center"><h6>{{ $item->product }}</h6></td>
                                <td class="text-center"><h6>${{ number_format($item->price,2) }}</h6></td>
                                <td class="text-center"><h6>{{ $item->quantity }}</h6></td>
                                <td class="text-center"><h6>{{ number_format($item->price * $item->quantity,2) }}</h6></td>
                            </tr>
                        @endforeach
                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="3"><h5 class="text-center font-weight-bold">Totales</h5></td>
                            <td><h5 class="text-center">{{ $countDetails }}</h5></td>
                            <td><h5 class="text-center">${{ number_format($sumDetails,2) }}</h5></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" wire:click.prevent="close()" class="btn btn-dark close-btn text-info" data-bs-dismiss="modal">Cerrar</button>

        </div>
    </div>
</div>
</div>