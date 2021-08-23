<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Permission;

use Livewire\WithPagination;


class Permiso extends Component
{
    use WithPagination;

    public $componentName, $pageTitle, $search, $permisoName, $selected_id;
    private $pagination = 10;

    protected $listeners = [
        'deleteRow' => 'destroy'
    ];

    public function mount()
    {
        $this->componentName = 'Permisos';
        $this->pageTitle = 'Listado';
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        if(strlen($this->search) > 0)
            $permisos = Permission::where('name', 'like', '%' . $this->search . '%')->paginate($this->pagination);
        else
            $permisos = Permission::orderBy('name', 'asc')->paginate($this->pagination);

        return view('livewire.permisos.permission', compact('permisos'))
                ->extends('adminlte::page')
                ->section('content');
    }

    public function resetUI()
    {
        $this->permisoName = '';
        $this->selected_id = 0;
        $this->resetValidation();

        $this->emit('cancel', 'cancelar');
    }

    public function CreatePermiso()
    {
        $rules = [
            'permisoName' => 'required|min:2|unique:permissions,name'
        ];

        $messages = [
            'permisoName.required' => 'El nombre es requiredo',
            'permisoName.min' => 'Se requiere minimo 2 caracteres',
            'permisoName.unique' => 'El permiso ya existe',
        ];

        $this->validate($rules, $messages);

        Permission::create(['name' => $this->permisoName]);

        $this->emit('permiso-added', 'Permiso agregado con exito');
        $this->resetUI();
    }

    public function edit(Permission $permiso)
    {
        $this->selected_id = $permiso->id;
        $this->permisoName = $permiso->name;

        $this->emit('show-modal', 'edit');
    }

    public function UpdatePermiso()
    {
        $rules = [
            'permisoName' => "required|min:2|unique:permissions,name,{$this->selected_id}"
        ];

        $messages = [
            'permisoName.required' => 'El nombre es requiredo',
            'permisoName.min' => 'Se requiere minimo 2 caracteres',
            'permisoName.unique' => 'El permiso ya existe',
        ];

        $permiso = Permission::find($this->selected_id);
        $permiso->update(['name' => $this->permisoName]);

        $this->resetUI();
        $this->emit('permiso-updated', 'Permiso Actualizado');
    }

    public function destroy($id)
    {
        $rolesCount = Permission::find($id)->getRoleNames()->count();

        if ($rolesCount > 0) {
            $this->emit('permiso-error', 'No se puede eliminar el permiso que tiene roles asociados');
            return;
        }

        Permission::find($id)->delete();

        $this->emit('permiso-deleted', 'permiso eliminado');
    }
}
