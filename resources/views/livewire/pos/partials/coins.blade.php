<div class="row mt-1">
    <div class="col-sm-12">
        <div class="card">

          <div class="card-header">
              <h5 class="text-center text-muted mb-3">Denominaciones</h5>
          </div>

          <div class="card-body">
            <div class="row">
                @foreach ($denominations as $item)
                    <div class="col-sm  mt-2">

                        <button wire:click.prevent="Acash({{$item->value}})" class="btn btn-dark btn-block">
                            {{$item->value > 0 ? '$' . number_format($item->value, 2, '.', '') : 'Exacto' }}
                        </button>

                    </div>
                @endforeach
            </div>
          </div>

          <div class="card-footer mt-1">

              <div class="input-group input-group-md mb-2">

                  <div class="input-group-prepend">
                        <span class="input-group-text hideonsm bg-dark" style="background: #3B3F5C; color: white">
                            Efectivo F8
                        </span>
                  </div>

                  <input type="number" 
                    id="cash" 
                    wire:model="efectivo" 
                    wire:keydown.center="saveSale" 
                    class="form-control text-center"
                    value="${{number_format($efectivo,2)}}"
                  >

                  <div class="input-group-prepend">
                      <span wire:click="set('efectivo', 0)" class="input-group-text" style="background: #3B3F5C; color: white">
                            <i class="fas fa-backspace fa-1x"></i>
                      </span>
                  </div>
              </div>

              <h4 class="text-muted">Cambio: ${{number_format($change, 2)}}</h4>

              <div class="row justify-content-between">

                  <div class="col-sm-12 col-md-12 col-lg-6">
                    @if ($total > 0)
                        <button onclick="Confirm('', 'clearCart', '¿Seguro de eliminar los productos?')" class="btn btn-dark btn-sm">
                            Cancelar F4
                        </button>
                    @endif
                  </div>

                  <div class="col-sm-12 col-md-12 col-lg-6">
                    @if ($efectivo >= $total && $total > 0)
                        <button wire:click.prevent="saveSale" class="btn btn-dark btn-sm">
                            Guardar F9
                        </button>
                    @endif
                  </div>

              </div>

          </div>
        </div>
    </div>
</div>