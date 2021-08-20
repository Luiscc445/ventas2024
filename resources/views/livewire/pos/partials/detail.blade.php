<div class="card">
    <div class="card-body">

        <livewire:search>

        @if($total > 0)

            <div class="table-responsive tblscroll" style="max-height: 650px; overflow: hidden">
                <table class="table table-bordered table-striped mt-1">

                    <thead class="text-white bg-dark">
                        <tr>
                            <th width="10%"></th>
                            <th class="table-th text-left text-white">Descripción</th>
                            <th class="table-th text-center text-white">Precio</th>
                            <th width="13%" class="table-th text-center text-white">Cant</th>
                            <th class="table-th text-center text-white">Importe</th>
                            <th class="table-th text-center text-white"></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($cart as $item)
                            <tr>
                                <td class="text-center table-th">
                                    @if (count($item->attributes) > 0)                                   
                                        <span>
                                            <img src="{{ asset('storage/products/' . $item->attributes[0]) }}" alt="imagen" class="rounded" width="90" height="90">
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <h6>{{ $item->name }}</h6>
                                </td>

                                <td class="text-center">
                                    ${{ number_format($item->price, 2) }}
                                </td>

                                <td>
                                    <input type="number" id="r{{ $item->id }}" 
                                    wire.change="updateQty({{ $item->id }} , $('#r' + {{ $item->id }}).val() )"
                                    style="font-size: 1rem!important"
                                    class="form-control text-center"
                                    value="{{$item->quantity}}">
                                </td>

                                <td class="text-center">
                                    <h6>${{ number_format($item->price * $item->quantity, 2) }}</h6>
                                </td>

                                <td class="text-center">

                                    <button onclick="Confirm('{{$item->id}}', 'remuveItem', '¿Confirmas eliminar el registro?')" class="btn btn-sm btn-dark">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>

                                    <button wire:click.prevent="decrementQuantity({{$item->id}})" class="btn btn-sm btn-dark">
                                        <i class="fas fa-minus"></i>
                                    </button>

                                    <button wire:click.prevent="incrementQuantity({{$item->id}})" class="btn btn-sm btn-dark">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        
        @else
          
            <h5 class="text-center text-muted mt-2">Agrega productos a la venta</h5>

        @endif
        
        <div wire:loading.inline wire:target="saveSale">
            <h4 class="text-danger text-center">Guardando venta...</h4>
        </div>
    </div>
</div>