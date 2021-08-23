<div class="row">
    <div class="col-sm-12 mt-4">
        <div class="card">
            
            <div class="card-header">
                <h4 class="card-title">
                    <b>{{$componentName}}</b>
                </h4>
                <div class="card-tools">
                  
                </div>
            </div>
        

            <div class="card-body">

                <div class="form-inline">

                    <div class="form-group mr-5">
                        <select wire:model="role">
                            <option value="elegir" selected>== Seleccione el Role ==</option>
                            @foreach ($roles as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <button 
                    wire:click.prevent="SyncAll()" 
                    type="button" 
                    class="btn btn-dark inblock mr-5">
                        Sincronizar todos
                    </button>

                    <button 
                    onclick="Revocar()" 
                    type="button" 
                    class="btn btn-dark mr-5">
                        Revocar todos
                    </button>
                </div>

                <div class="row mt-3">
                    <div class="col-sm-12">

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mt-1">
        
                                <thead class="text-white bg-dark">
                                    <tr>
                                        <th class="table-th text-white text-center">Id</th>
                                        <th class="table-th text-white text-center">Permiso</th>
                                        <th class="table-th text-white text-center">Roles con el permiso</th>
                                    </tr>
                                </thead>
        
                                <tbody>
                                    @foreach ($permisos as $item)
                                        <tr>
                                            
                                            <td><h6 class="text-center">{{ $item->id }}</h6></td>

                                            <td class="text-center">
                                                
                                                <div class="form-check">
                                                    <input 
                                                    type="checkbox" 
                                                    wire:change="SyncPermiso($('#p' + {{ $item->id }}).is(':checked'), '{{ $item->name }}')" 
                                                    id="p{{ $item->id }}"
                                                    value="{{ $item->id }}" 
                                                    class="form-check-input" 
                                                    {{ $item->checked == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="p{{ $item->id }}">
                                                      <h6>{{ $item->name }}</h6>
                                                    </label>
                                                </div>

                                            </td>

                                            <td class="text-center">
                                                <h6>{{ \App\Models\User::permission($item->name)->count() }}</h6> 
                                            </td>
                                            
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $permisos->links() }}
                            
                        </div>

                    </div>
                </div>
                
            </div>
        </div>
    </div>


</div>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        window.livewire.on('sync-error', msg => {
            Swal.fire(msg)
        })

        window.livewire.on('permi', msg => {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: msg,
                showConfirmButton: false,
                timer: 2000
            })
        })

        window.livewire.on('syncall', msg => {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: msg,
                showConfirmButton: false,
                timer: 2000
            })
        })

        window.livewire.on('removeall', msg => {
            
        })
    });

    function Revocar()
    {

        Swal.fire({
            title: 'Confirmar',
            text: "¿Estas segur@ de revocar todos los permisos?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3B3F5C',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Aceptar'
            }).then((result) => {
            if (result.isConfirmed) {
                window.livewire.emit('revokeall')
                Swal.fire(
                'Eliminado!',
                'Permisos revocados.',
                'success'
                )
            }
        })
    };
</script>