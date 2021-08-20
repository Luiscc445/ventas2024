<div class="input-group flex-nowrap">
    <span class="input-group-text" id="addon-wrapping"> <i class="fas fa-search"></i> </span>
    <input id="code" type="number" wire:keydown.enter.prevent="$emit('scan-code', $('#code').val())" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="addon-wrapping">
</div>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        livewire.on('scan-code', action => {
            $('#code').val('')
        })
    })
</script>