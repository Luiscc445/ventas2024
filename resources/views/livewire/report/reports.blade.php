<div class="row">
    <div class="col-12 mt-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title text-center">
                    <b>{{ $componentName }}</b>
                </h4>
            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-sm-12 col-md-3">
                        <div class="row">
    
                            <div class="col-sm-12">
                                <h6>Elige el usuario</h6>
                                <div>
                                    <select wire:model="userId" class="form-control">
                                        <option value="0" selected>Todos</option>
                                        @foreach ($users as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
    
                            <div class="col-sm-12">
                                <h6>Elige el tipo de reporte</h6>
                                <div>
                                    <select wire:model="reportType" class="form-control">
                                        <option value="0">Ventas del dia</option>
                                        <option value="1">Ventas por fecha</option>
                                    </select>
                                </div>
                            </div>
    
                            <div class="col-sm-12 mt-2">
                                <h6>Fecha desde</h6>
                                <div>
                                    <input type="text" wire:model="fromDate" class="form-control flatpickr" placeholder="Click para elegir">
                                </div>
                            </div>
    
                            <div class="col-sm-12 mt-2">
                                <h6>Fecha hasta</h6>
                                <div>
                                    <input type="text" wire:model="toDate" class="form-control flatpickr" placeholder="Click para elegir">
                                </div>
                            </div>
    
                            <div class="col-sm-12 mt-3">
                                <button wire:click="$refresh" class="btn btn-dark btn-block">Consultar</button>
    
                                <a class="btn btn-dark btn-block {{ count($data) < 1 ? 'disabled' : '' }}" 
                                href="{{ url('report/pdf' . '/' . $userId . '/' . $reportType) . '/' . $fromDate . '/' . $toDate }}" target="_blank">Generar a PDF</a>
                                
                                <a class="btn btn-dark btn-block {{ count($data) < 1 ? 'disabled' : '' }}" 
                                href="{{ url('report/excel' . '/' . $userId . '/' . $reportType) . '/' . $fromDate . '/' . $toDate }}" target="_blank">Exportar a Excel</a>
                            </div>
    
                        </div>
                    </div>
    
                    <div class="col-sm-12 col-md-9">
    
                        <div class="table-responsive">
    
                            <table class="table table-bordered table-striped mt-1">
        
                                <thead class="text-white bg-dark">
                                    <tr>
                                        <th class="table-th text-white text-center">Folio</th>
                                        <th class="table-th text-white text-center">Total</th>
                                        <th class="table-th text-white text-center">Items</th>
                                        <th class="table-th text-white text-center">Estatus</th>
                                        <th class="table-th text-white text-center">Usuario</th>
                                        <th class="table-th text-white text-center">Fecha</th>
                                        <th class="table-th text-white text-center" width="50px"></th>
                                    </tr>
                                </thead>
        
                                <tbody>
                                    @if (count($data) < 1)
                                        <tr>
                                            <td colspan="7"><h5 class="text-center">Sin resultados</h5></td>
                                        </tr>
                                    @endif
    
                                    @foreach ($data as $item)
                                        <tr>
                                            <td class="text-center"><h6> {{ $item->id }} </h6></td>
                                            <td class="text-center"><h6> ${{ number_format($item->total,2) }} </h6></td>
                                            <td class="text-center"><h6> {{ $item->items }} </h6></td>
                                            <td class="text-center"><h6> {{ $item->status }} </h6></td>
                                            <td class="text-center"><h6> {{ $item->user }} </h6></td>
                                            <td class="text-center">
                                                <h6> 
                                                    {{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }} 
                                                </h6>
                                            </td>
                                            <td class="text-center" width="50px">
                                                <button wire:click.prevent="getDetails({{ $item->id }})" class="btn btn-sm btn-dark">
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
    @include('livewire.report.sales-details')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr(document.getElementsByClassName('flatpickr'),{
            enableTime: false,
            dateFormat: 'Y-m-d',
            locale: {
                firstDayofWeek: 1,
                weekdays: {
                    shorthand: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],
                    longhand: [
                    "Domingo",
                    "Lunes",
                    "Martes",
                    "Miércoles",
                    "Jueves",
                    "Viernes",
                    "Sábado",
                    ],
                },

                months: {
                    shorthand: [
                    "Ene",
                    "Feb",
                    "Mar",
                    "Abr",
                    "May",
                    "Jun",
                    "Jul",
                    "Ago",
                    "Sep",
                    "Oct",
                    "Nov",
                    "Dic",
                    ],
                    longhand: [
                    "Enero",
                    "Febrero",
                    "Marzo",
                    "Abril",
                    "Mayo",
                    "Junio",
                    "Julio",
                    "Agosto",
                    "Septiembre",
                    "Octubre",
                    "Noviembre",
                    "Diciembre",
                    ],
                },

            }
        })

        // Eventos

        window.livewire.on('show-modal', msg => {
            $('#theModal').modal('show')
        })

        window.livewire.on('close', msg => {
            $('#theModal').modal('hide')
        })
        
    });
</script>