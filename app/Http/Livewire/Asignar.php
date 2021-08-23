<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

use Livewire\WithPagination;

class Asignar extends Component
{
    use WithPagination;

    public $componentName, $role, $permisosSelected = [], $old_permissions = [];
    private $pagination = 5;

    public function mount()
    {
        $this->componentName = 'Asignar Permisos';
        $this->role = 'elegir';
    }

    protected $listeners = ['revokeall' => 'Removeall'];

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        $permisos = Permission::select('id', 'name', DB::raw("0 as checked"))
                    ->orderBy('name', 'asc')
                    ->paginate($this->pagination);

        $roles = Role::orderBy('name', 'asc')->get();

        if($this->role != 'elegir')
        {
            $list = Permission::join('role_has_permissions as rp', 'rp.permission_id', 'permissions.id')
                    ->where('role_id', $this->role)->pluck('permissions.id')->toArray();

            $this->old_permissions = $list;
        }

        if($this->role != 'elegir')
        {
            foreach ($permisos as $permiso) {
                $role = Role::find($this->role);
                $hasPermissions = $role->hasPermissionTo($permiso->name);
                
                if($hasPermissions)
                {
                    $permiso->checked = 1;
                }
            }
        }

        return view('livewire.asignar.asignar', compact('permisos', 'roles'))
            ->extends('adminlte::page')
            ->section('content');
    }

    public function Removeall()
    {
        if($this->role == 'elegir')
        {
            $this->emit('sync-error', 'Seleccione un role valido');
            return;
        }

        $role = Role::find($this->role);
        $role->syncPermissions([0]);

        $this->emit('removeall', "Se revocarion todos los permisos al role $role->name");
    }

    public function SyncAll()
    {
        if($this->role == 'elegir')
        {
            $this->emit('sync-error', 'Seleccione un role valido');
            return;
        }

        $role = Role::find($this->role);
        $permisos = Permission::pluck('id')->toArray();
        $role->syncPermissions($permisos);

        $this->emit('syncall', "Se sincronizaron todos los permisos al role $role->name");
    }

    public function SyncPermiso($state, $permisoName)
    {
        
        
        if($this->role != 'elegir')
        {
            $roleName = Role::find($this->role);

            if($state)
            {
                $roleName->givePermissionTo($permisoName);
                $this->emit('permi', "Permiso asignado");
            } else {
                $roleName->revokePermissionTo($permisoName);
                $this->emit('permi', "Permiso revocado");
            }

        } else {
            $this->emit('sync-error', "Elige un role valido");
        }

    }
}
