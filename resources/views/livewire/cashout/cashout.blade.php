<div class="row">
    <div class="col-sm-12 mt-4">
        <div class="card">

            <div class="card-header">
                <h4 class="card-title">
                    <b>Corte de Caja</b>
                </h4>
            </div>

            <div class="card-body">
                <div class="row">

                    <div class="col-sm-12 col-md-3">
                        <div>
                            <label>Usuario</label>
                            <select wire:model="userid" class="form-control">
                                <option value="0" disabled>Elegir</option>
                                @foreach ($users as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('userid')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-3">
                        <div>
                            <label>Fecha inicial</label>
                            <input type="date" wire:model.lazy="fromDate" class="form-control">
                            @error('fromDate')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-3">
                        <div>
                            <label>Fecha final</label>
                            <input type="date" wire:model.lazy="toDate" class="form-control">
                            @error('toDate')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-3 align-self-center d-flex justify-content-around">   
                        @if ($userid > 0 && $fromDate != null && $toDate != null)                            
                            <button type="button" wire:click.prevent="consultar" class="btn btn-sm btn-dark">Consultar</button>
                        @endif    
                        
                        @if ($total > 0)                            
                            <button type="button" wire:click.prevent="print()" class="btn btn-sm btn-dark">Imprimer</button>
                        @endif
                    </div>

                </div>

                <div class="row">

                    <div class="col-sm-12 col-md-4 mt-5">
                        <div class="alert alert-dark">
                            <h5 class="text-white">Ventas totales: ${{ number_format($total,2) }}</h5>
                            <h5 class="text-white">Articulos: {{ $items }}</h5>
                        </div>
                    </div>

                    <div class="col-ms-12 col-md-8 mt-5">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mt-1">
                                <thead class="text-white bg-dark">
                                    <tr>
                                        <th class="table-th text-center text-white">Folio</th>
                                        <th class="table-th text-center text-white">Total</th>
                                        <th class="table-th text-center text-white">Items</th>
                                        <th class="table-th text-center text-white">Fecha</th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @if ($total <= 0)
                                        <tr>
                                            <td colspan="5"><h6 class="text-center">no hay ventas en la fecha seleccionada</h6></td>
                                        </tr>
                                    @endif

                                    @foreach ($sales as $item)
                                        <tr>
                                            <td class="text-cener"><h6>{{ $item->id }}</h6></td>
                                            <td class="text-cener"><h6>${{ number_format($item->total,2) }}</h6></td>
                                            <td class="text-cener"><h6>{{ $item->items }}</td>
                                            <td class="text-cener"><h6>{{ $item->created_at }}</td>
                                            <td class="text-cener">
                                                <button wire:click.prevent="viewDetail({{ $item }})" class="btn btn-sm btn-dark">
                                                    <i class="fas fa-list"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    @include('livewire.cashout.modalDetails')

</div>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        window.livewire.on('show-modal', msg => {
            $('#modal-details').modal('show')
        })
    });
</script>