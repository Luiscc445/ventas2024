<div class="row">
    <div class="col-sm-12 mt-4">
        <div class="card">
            
            <div class="card-header">
                <h4 class="card-title">
                    <b> {{ $componentName }} | {{ $pageTitle }}</b>
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
                                <th class="table-th text-white">Id</th>
                                <th class="table-th text-white text-center">Descripción</th>
                                
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($roles as $item)
                                <tr>
                                    <td><h6> {{ $item->id }} </h6></td>

                                    <td class="text-center">
                                        <h6>{{ $item->name }}</h6>
                                    </td>

                                    <td class="text-center">

                                        <a href="javascript:void(0)" 
                                        wire:click="edit({{ $item->id }})"
                                        class="btn btn-dark" 
                                        title="edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <a href="javascript:void(0)" 
                                        onclick="Confirm('{{ $item->id }}')"
                                        class="btn btn-dark" 
                                        title="deleteRow">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                    {{ $roles->links() }}

                </div>
                
            </div>
        </div>
    </div>

    @include('livewire.roles.form')

</div>

<script>
    document.addEventListener('DOMContentLoaded', function(){

        window.livewire.on('show-modal', msg => {
            $('#theModal').modal('show')
        })

        window.livewire.on('cancel', msg => {
            $('#theModal').modal('hide')
        });

        window.livewire.on('role-added', msg => {
            $('#theModal').modal('hide')
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: msg,
                showConfirmButton: false,
                timer: 2000
            })
        });

        window.livewire.on('role-updated', msg => {
            $('#theModal').modal('hide')
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: msg,
                showConfirmButton: false,
                timer: 2000
            })
        });

        window.livewire.on('role-deleted', msg => {
            noty(msg)
        });

        window.livewire.on('role-exists', msg => {
            noty(msg)
        });

        window.livewire.on('role-error', msg => {
            Swal.fire(msg)
        });

        

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
                'Denominacion eliminada.',
                'success'
                )
            }
        })
    };
</script>