<div class="row">
    <div class="col-sm-12 mt-4">
        <div class="card">
            
            <div class="card-header">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <div class="card-tools">
                  <ul class="pagination pagination-sm float-right">
                    <a href="javascript:void(0)" class="btn btn-sm bg-dark" data-toggle="modal" data-target="#theModal">Agregar</a>
                  </ul>
                </div>
            </div>

            @include('common.searchbox')

            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-bordered table-striped mt-1">

                        <thead class="text-white bg-dark">
                            <tr>
                                <th class="table-th text-white text-center">Usuario</th>
                                <th class="table-th text-white text-center">Correo</th>
                                <th class="table-th text-white text-center">Imagen</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($users as $item)
                                <tr>
                                    <td><h6 class="text-center">{{ $item->name }}</h6></td>
                                    <td><h6 class="text-center">{{ $item->email }}</h6></td>

                                    <td class="text-center">
                                        
                                        <span>
                                            <img src="{{ asset('storage/users/' . $item->image) }}" alt="imagen" class="card-img-top img-fluid">
                                        </span>
                                                                            

                                    </td>
                                    <td class="text-center">

                                        <a href="javascript:void(0)"
                                        wire:click="edit({{ $item->id }})"
                                         class="btn btn-dark" 
                                         title="edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <a href="javascript:void(0)" 
                                        onclick="Comfirm('{{ $item->id }}')"
                                        class="btn btn-dark" 
                                        title="delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $users->links() }}
                </div>
                
            </div>
        </div>
    </div>

    @include('livewire.user.form')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function(){

        window.livewire.on('show-modal', msg => {
            $('#theModal').modal('show')
        })

        window.livewire.on('cancel', msg => {
            $('#theModal').modal('hide')
        });

        window.livewire.on('user-added', msg => {
            $('#theModal').modal('hide')
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: msg,
                showConfirmButton: false,
                timer: 2000
            })
        })

        window.livewire.on('user-updated', msg => {
            $('#theModal').modal('hide')
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: msg,
                showConfirmButton: false,
                timer: 2000
            })
        })

        window.livewire.on('user-withsales', msg => {
            Swal.fire(msg)
        })

        window.livewire.on('user-delete', msg => {
            
        })

    });

    function Confirm(id)
    {

        Swal.fire({
            title: 'Confirmar',
            text: "¿Estas seguro de eliminar el registro?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3B3F5C',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Aceptar'
            }).then((result) => {
            if (result.isConfirmed) {
                window.livewire.emit('deleteRow', id)
                Swal.fire(
                'Eliminado!',
                'Usuario eliminado.',
                'success'
                )
            }
        })
    };
</script>