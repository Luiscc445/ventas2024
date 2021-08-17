@include('common.modalHead')

    <div class="row">
        <div class="col-sm-12 col-md-8">

            <div class="input-group">
                <label>Nombre</label>
                <input type="text" wire:model.lazy="name" class="form-control" placeholder="Ej: cursos">

                @error('name')
                    <span class="text-danger er">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-sm-12 col-md-4 mt-3">
            <div class="input-group">
                <label>Código</label>
                <input type="text" wire:model.lazy="barcode" class="form-control" placeholder="Ej: 134567">

                @error('barcode')
                    <span class="text-danger er">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-sm-12 col-md-4 mt-3">
            <div class="input-group">
                <label>Costo</label>
                <input type="text" data-type="currency" wire:model.lazy="cost" class="form-control" placeholder="Ej: 0.00">

                @error('cost')
                    <span class="text-danger er">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-sm-12 col-md-4 mt-3">
            <div class="input-group">
                <label>Precio</label>
                <input type="text" data-type="currency" wire:model.lazy="price" class="form-control" placeholder="Ej: 0.00">

                @error('price')
                    <span class="text-danger er">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-sm-12 col-md-4 mt-3">
            <div class="input-group">
                <label>Stock</label>
                <input type="number" data-type="currency" wire:model.lazy="stock" class="form-control" placeholder="Ej: 0">

                @error('stock')
                    <span class="text-danger er">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-sm-12 col-md-4 mt-3">
            <div class="input-group">
                <label>Alertas</label>
                <input type="number" data-type="currency" wire:model.lazy="alert" class="form-control" placeholder="Ej: 5">

                @error('alert')
                    <span class="text-danger er">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-sm-12 col-md-4 mt-3">
            <div class="input-group">
                <label>Categoria</label>
                <select wire:model="categoryid" class="form-control">
                    <option value="Elegir" disabled>Elegir</option>

                    @foreach ($categories as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                    
                </select>
            </div>
        </div>

        <div class="col-sm-12 col-md-8 mt-3">
            <div class="form-group custom-file">
                <input type="file" class="form control custom-file-input" wire:model.lazy="image" accept="image/x-png, image/gif, image/jpeg">
                <label class="custom-file-label">Imágen {{ $image }}</label>

                @error('image')
                    <span class="text-danger er">{{ $message }}</span>
                @enderror
            </div>
        </div>

    </div>

@include('common.modalFooter')