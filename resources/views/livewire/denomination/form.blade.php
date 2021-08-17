@include('common.modalHead')

<div class="row">
    <div class="col-sm-6">

        <label>Tipo</label>
        
        <div class="input-group">
            <select wire:model="type" class="form-control">
                <option value="Elegir">Elegir</option>
                <option value="BILLETE">Billete</option>
                <option value="MONEDA">Moneda</option>
                <option value="OTRO">Otro</option>
            </select>

            @error('type')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-sm-6">
        <label>Valor</label>
       
        <div class="input-group">
            <input type="text" wire:model.lazy="value" class="form-control" placeholder="0.00">

            @error('value')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>

    
</div>


@include('common.modalfooter')