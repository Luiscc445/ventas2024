@include('common.modalHead')

    <div class="row">

        <div class="col-sm-12 col-md-8">
            <div>
                <label>Nombre</label>
                <input type="text" wire:model.lazy="name" class="form-control" placeholder="ej: Jaiver Ramos">

                @error('name')
                    <span class="text-danger er">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-sm-12 col-md-4">
            <div>
                <label>Telefono</label>
                <input type="text" wire:model.lazy="phone" class="form-control" maxlength="10" placeholder="ej: 304 385 0685">

                @error('phone')
                    <span class="text-danger er">{{ $message }}</span>
                @enderror
            </div>            
        </div>

        <div class="col-sm-12 col-md-6 mt-3">
            <div>
                <label>Email</label>
                <input type="email" wire:model.lazy="email" class="form-control" placeholder="ej: jaiver.ramos7942@gmail.com">

                @error('email')
                    <span class="text-danger er">{{ $message }}</span>
                @enderror
            </div>            
        </div>

        <div class="col-sm-12 col-md-6 mt-3">
            <div>
                <label>Contraseña</label>
                <input type="password" wire:model.lazy="password" class="form-control">

                @error('password')
                    <span class="text-danger er">{{ $message }}</span>
                @enderror
            </div>            
        </div>

        <div class="col-sm-12 col-md-6 mt-3">
            <div>
                <label>Status</label>
                <select wire:model.lazy="status" class="form-control">
                    <option value="elegir" selected>== Elegir ==</option>
                    <option value="AVTIVE">Activo</option>
                    <option value="LOCKED">Bloquea@</option>
                </select>

                @error('status')
                    <span class="text-danger er">{{ $message }}</span>
                @enderror
            </div>            
        </div>

        <div class="col-sm-12 col-md-6 mt-3">
            <div>
                <label>Asignar Role</label>
                <select wire:model.lazy="profile" class="form-control">
                    <option value="elegir" selected>== Elegir ==</option>
                    @foreach ($roles as $item)
                        <option value="{{ $item->name }}">{{ $item->name }}</option>
                    @endforeach
                </select>

                @error('profile')
                    <span class="text-danger er">{{ $message }}</span>
                @enderror
            </div>            
        </div>

        <div class="col-sm-12 col-md-12 mt-3">
            <div>
                <label>Imagen de perfil</label>
                <input type="file" class="form-control" wire:model.lazy="image" accept="image/x-png, image/gif, image/jpeg">

                @error('image')
                    <span class="text-danger er">{{ $message }}</span>
                @enderror
            </div>            
        </div>


    </div>

@include('common.modalFooter')