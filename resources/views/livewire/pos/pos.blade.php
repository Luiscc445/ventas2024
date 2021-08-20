<div>
    <style></style>

    <div class="row">

        <div class="col-sm-12 col-md-8 mt-4">
            <!-- Detail -->
            @include('livewire.pos.partials.detail')
        </div>

        <div class="col-sm-12 col-md-4 mt-4">
            <!-- total -->
            @include('livewire.pos.partials.total')

            <!-- coins -->
            @include('livewire.pos.partials.coins')
        </div>
        
    </div>

</div>

@include('livewire.pos.scripts.events')
@include('livewire.pos.scripts.scan')
@include('livewire.pos.scripts.general')
@include('livewire.pos.scripts.shorcust')
