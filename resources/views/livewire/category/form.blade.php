@include('common.modalHead')

<div class="row">
    <div class="col-sm-12">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <span class="fas fa-edit"></span>
                </span>
            </div>
            <input type="text" wire:model.lazy="name" class="form-control" placeholder="Ej: cursos">
        </div>
        @error('name')
            <span class="text-danger er">{{ $message }}</span>
        @enderror
    </div>
</div>

<div class="col-sm-12 mt-3">
    <div class="form-group custom-file">
        <input type="file" class="custom-file-input" wire:model="image" accept="image/jpeg">
        <label class="custom-file-label">{{ $image ? $image->getClientOriginalName() : 'Elegir imagen JPG' }}</label>
    </div>
    @error('image')
        <span class="text-danger er">{{ $message }}</span>
    @enderror
</div>

@if ($image)
    <div class="col-sm-12 mt-3">
        <img src="{{ $image->temporaryUrl() }}" alt="Vista previa" class="img-fluid img-thumbnail" style="max-height: 200px;">
    </div>
@elseif($selected_id && $name)
    <div class="col-sm-12 mt-3">
        <img src="{{ asset('storage/categories/' . $name . '.jpg') }}" alt="Imagen actual" class="img-fluid img-thumbnail" style="max-height: 200px;">
    </div>
@endif

@include('common.modalFooter')

<script>
    document.addEventListener('livewire:load', function () {
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });
    });
</script>