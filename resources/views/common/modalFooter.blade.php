            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn text-info" data-bs-dismiss="modal">Cerrar</button>
                
                @if ($selected_id < 1)
                    <button type="button" wire:click.prevent="save()"  class="btn btn-dark">Guardar</button>                    
                @else
                    <button type="button" wire:click.prevent="update()" class="btn btn-dark">Actualizar</button>
                @endif
            </div>
        </div>
    </div>
</div>