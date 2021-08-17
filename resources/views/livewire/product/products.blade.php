<div class="row">
    <div class="col-sm-12 mt-4">
        <div class="card">

            <div class="card-header">

                <h4 class="card-title">
                    <b>{{ $componentName }}</b> | {{ $pageName }}
                </h4>

                <div class="card-tools">
                    <ul class="pagination pagination-sm float-right">
                      <a href="javascript:void(0)" class="btn btn-sm bg-dark" data-toggle="modal" data-target="#theModal">Agregar</a>
                    </ul>
                </div>

            </div>

            @include('common.searchbox')

            <div class="card-body">

                <div class="table-response">
                    <table class="table table-bordered table-striped mt-1">

                        <thead class="text-white bg-dark">
                            <tr>
                                <th class="table-th text-white">Descripción</th>
                                <th class="table-th text-white">Codigo de barra</th>
                                <th class="table-th text-white">Categoria</th>
                                <th class="table-th text-white">Precio</th>
                                <th class="table-th text-white">Stock</th>
                                <th class="table-th text-white">Imagen</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($products as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->barcode }}</td>
                                    <td>{{ $item->category }}</td>
                                    <td>{{ $item->price }}</td>
                                    <td>{{ $item->stock }}</td>

                                    <td class="text-center">
                                        <span>
                                            <img src="{{ asset('storage/products/'. $item->image) }}" alt="imagen de ejemplo" height="60" width="70" class="rounded">
                                        </span>
                                    </td>

                                    <td>
                                        <a href="javascript:void(0)" 
                                        wire:click="edit({{ $item->id }})"
                                        class="btn btn-dark btn-ms"
                                        title="edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <a href="javascript:void(0)"
                                        onclick="Confirm({{ $item->id }})"
                                        class="btn btn-dark btn-ms"
                                        title="delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $products->links() }}

                </div>

            </div>


        </div>
    </div>

    @include('livewire.product.form')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function(){

        window.livewire.on('show-modal', msg => {
            $('#theModal').modal('show')
        })

        window.livewire.on('product-added', msg => {
            $('#theModal').modal('hide')
        })

        window.livewire.on('product-updated', msg => {
            $('#theModal').modal('hide')
        })

        window.livewire.on('product-deleted', msg => {
           // noty
        })

        window.livewire.on('cancel', msg => {
            $('#theModal').modal('hide')
        })

        window.livewire.on('hidden.bs.modal', msg => {
            $('.er').css('display', 'none')
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
                'Producto eliminado.',
                'success'
                )
            }
        })
    };
</script>