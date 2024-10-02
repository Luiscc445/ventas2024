<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class Roles extends Component
{
    use WithPagination;

    public $componentName, $pageTitle, $search, $roleName, $selected_id;
    private $pagination = 5;

    protected $listeners = [
        'deleteRow' => 'destroy'
    ];

    public function mount()
    {
        $this->componentName = 'Roles';
        $this->pageTitle = 'Listado';
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        if (strlen($this->search) > 0)
            $roles = Role::where('name', 'like', '%' . $this->search . '%')->paginate($this->pagination);
        else
            $roles = Role::orderBy('name', 'asc')->paginate($this->pagination);

        return view('livewire.roles.roles', compact('roles'))
            ->extends('adminlte::page')
            ->section('content');
    }

    public function resetUI()
    {
        $this->roleName = '';
        $this->selected_id = 0;
        $this->resetValidation();

        $this->emit('cancel', 'cancelar');
    }

    public function CreateRole()
    {
        $rules = [
            'roleName' => 'required|min:2|unique:roles,name'
        ];

        $messages = [
            'roleName.required' => 'El nombre es requiredo',
            'roleName.min' => 'Se requiere minimo 2 caracteres',
            'roleName.unique' => 'El rol ya existe',
        ];

        $this->validate($rules, $messages);

        Role::create(['name' => $this->roleName]);

        $this->emit('role-added', 'Rol agregado con exito');
        $this->resetUI();
    }

    public function edit(Role $role)
    {
        $this->selected_id = $role->id;
        $this->roleName = $role->name;

        $this->emit('show-modal', 'edit');
    }

    public function UpdateRole()
    {
        $rules = [
            'roleName' => "required|min:2|unique:roles,name,{$this->selected_id}"
        ];

        $messages = [
            'roleName.required' => 'El nombre es requiredo',
            'roleName.min' => 'Se requiere minimo 2 caracteres',
            'roleName.unique' => 'El rol ya existe',
        ];

        $role = Role::find($this->selected_id);
        $role->update(['name' => $this->roleName]);

        $this->resetUI();
        $this->emit('role-updated', 'Rol Actualizado');
    }

    public function destroy($id)
    {
        $permissionsCount = Role::find($id)->permissions->count();

        if ($permissionsCount > 0) {
            $this->emit('role-error', 'No se puede eliminar el rol que tiene permisos asociados');
            return;
        }

        Role::find($id)->delete();

        $this->emit('role-deleted', 'role eliminado');
    }

    public function asignarRoles($rolesList)
    {
        if ($this->userSelected > 0) {
            $user = USer::find($this->userSelected);
            if ($user) {
                $user->syncRoles($rolesList);
                $this->emit('msg-ok', 'Role asignado correctamente');
                $this->resetInput();
            }
        }
    }
}
