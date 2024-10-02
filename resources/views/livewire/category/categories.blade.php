<div class="row">
    <div class="col-sm-12 mt-4">
        <div class="card">
            
            <div class="card-header">
                <h4 class="card-title">
                    <b>{{ $componentName }}</b> | {{ $pageTitle }}
                </h4>
                <div class="card-tools">
                  <ul class="pagination pagination-sm float-right">
                    @can('categoria_create')
                    <a href="javascript:void(0)" class="btn btn-sm bg-dark" data-toggle="modal" data-target="#theModal">Agregar</a>
                    @endcan
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
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $item)
                                <tr>
                                    <td><h6>{{ $item->name }}</h6></td>
                                    <td class="text-center">
                                        <span>
                                            <img src="{{ asset('storage/categories/' . $item->name . '.jpg') }}" alt="imagen de {{ $item->name }}" height="70" width="80" class="rounded">
                                        </span>
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

        window.livewire.on('category-added', msg => {
            $('#theModal').modal('hide')
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: msg,
                showConfirmButton: false,
                timer: 2000
            })
        })

        window.livewire.on('category-updated', msg => {
            $('#theModal').modal('hide')
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: msg,
                showConfirmButton: false,
                timer: 2000
            })
        })

        window.livewire.on('cancel', msg => {
            $('#theModal').modal('hide')
        })
    });
</script>