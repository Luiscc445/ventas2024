<div class="row">
    <div class="col-sm-12 mt-4">
        <div class="card">
            
            <div class="card-header">
                <h4 class="card-title">
                    <b>{{ $componentName }}</b> | {{ $pageTitle }}
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
                                <th class="table-th text-white">Descripción</th>
                                <th class="table-th text-white">Imagen</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($categories as $item)
                                <tr>
                                    <td><h6> {{ $item->name }} </h6></td>
                                    <td class="text-center">
                                        <span>
                                            <img src="{{ asset('storage/categories/' . $item->imagen) }}" alt="imagen de ejemplo" height="60" width="70" class="rounded">
                                        </span>
                                    </td>
                                    <td class="text-center">

                                        <a href="javascript:void(0)" 
                                        wire:click="edit({{ $item->id }})"
                                        class="btn btn-dark btn-sm" 
                                        title="edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <a href="javascript:void(0)" 
                                        onclick="Confirm('{{ $item->id }}', '{{ $item->products->count() }}')"
                                        class="btn btn-dark btn-sm" 
                                        title="delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $categories->links() }}

                </div>
                
            </div>
        </div>
    </div>

    @include('livewire.category.form')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        window.livewire.on('show-modal', msg => {
            $('#theModal').modal('show')
        })

        window.livewire.on('cateory-added', msg => {
            $('#theModal').modal('hide')
        })

        window.livewire.on('category-updated', msg => {
            $('#theModal').modal('hide')
        })

        window.livewire.on('cancel', msg => {
            $('#theModal').modal('hide')
        })
    });

    function Confirm(id, products)
    {
        if(products > 0)
        {
            Swal.fire('No se puede eliminar esta categoria por que tiene productos asignados')
            return
        }

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
                'Categoria eliminada.',
                'success'
                )
            }
        })
    };
</script>