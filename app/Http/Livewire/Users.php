<?php

namespace App\Http\Livewire;

use App\Models\Sales;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\User;
use Spatie\Permission\Models\Role;

class Users extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $componentName, $pageTitle, $search, $name, $phone, $profile, $email, $password, $status, $image, $fileLoaded, $selected_id;
    private $pagination = 5;

    protected $listeners = ['deleteRow' => 'destroy'];

    public function mount()
    {
        $this->componentName = 'Usuarios';
        $this->pageTitle = 'Listado';
        $this->status = 'elegir';
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        if(strlen($this->search) > 0)
            $users = User::where('name', 'like', '%' . $this->search . '%')->orderby('name', 'asc')->paginate($this->pagination);
        else
            $users = User::select('*')->orderBy('name', 'asc')->paginate($this->pagination);

        $roles = Role::all();

        return view('livewire.user.users', compact('users', 'roles'))
            ->extends('adminlte::page')
            ->section('content');
    }

    public function resetUI()
    {
        $this->search = '';
        $this->name = '';;
        $this->phone = '';; 
        $this->profile = '';; 
        $this->email = '';; 
        $this->password = '';; 
        $this->status = 'elegir'; 
        $this->role = '';; 
        $this->image = '';
        $this->selected_id = 0;

        $this->resetValidation();
        $this->resetPage();
        
        $this->emit('cancel', 'cancelar');
    }

    public function edit(User $user)
    {
        $this->selected_id = $user->id;
        $this->name = $user->name;
        $this->phone = $user->phone;
        $this->profile = $user->profile;
        $this->email = $user->email;
        $this->password = '';
        $this->status = $user->status;
        $this->role = $user->role;

        $this->emit('show-modal', 'editando');
    }

    public function save()
    {
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|unique:users|email',
            'profile' => 'required|not_in:elegir',
            'status' => 'required|not_in:elegir',
            'password' => 'required|min:3',
        ];

        $messages = [
            'name.required' => 'El nombre es requerido',
            'name.min' => 'El nombre debe tener el menos 3 caracteres',
            'email.required' => 'El email es requerido',
            'email.unique' => 'El email ya existe',
            'email.email' => 'debe de ser un email',
            'profile.required' => 'Seleccione el perfil',
            'profile.not_in' => 'Seleccione el perfil',
            'status.required' => 'Seleccione el status',
            'status.not_in' => 'Seleccione el status',
            'password.required' => 'La contraseña es requerida',
            'password.min' => 'La contraseña debe tener el menos 3 caracteres',
        ];

        $this->validate($rules, $messages);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'profile' => $this->profile,
            'status' => $this->status,
            'password' => bcrypt($this->password),
        ]);

        if($this->image)
        {
            $customFileName = uniqid() . '_.' .$this->image->extension();
            $this->image->storeAs('public/users', $customFileName);
            $user->image = $customFileName;
            $user->save();
        }

        $this->resetUI();
        $this->emit('user-added', 'Usuario registrado');
    }

    public function update()
    {
        $rules = [
            'email' => "required|email|unique:users,email,{$this->selected_id}",
            'name' => 'required|min:3',
            'profile' => 'required|not_in:elegir',
            'status' => 'required|not_in:elegir',
            'password' => 'required|min:3',
        ];

        $messages = [
            'name.required' => 'El nombre es requerido',
            'name.min' => 'El nombre debe tener el menos 3 caracteres',
            'email.required' => 'El email es requerido',
            'email.unique' => 'El email ya existe',
            'email.email' => 'debe de ser un email',
            'profile.required' => 'Seleccione el perfil',
            'profile.not_in' => 'Seleccione el perfil',
            'status.required' => 'Seleccione el status',
            'status.not_in' => 'Seleccione el status',
            'password.required' => 'La contraseña es requerida',
            'password.min' => 'La contraseña debe tener el menos 3 caracteres',
        ];

        $this->validate($rules, $messages);

        $user = User::find($this->selected_id);

        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'profile' => $this->profile,
            'status' => $this->status,
            'password' => bcrypt($this->password),
        ]);

        if($this->image)
        {
            $customFileName = uniqid() . '_.' .$this->image->extension();
            $this->image->storeAs('public/users', $customFileName);
            $imageTemp = $user->image;

            $user->image = $customFileName;
            $user->save();

            if($imageTemp != null)
            {
                if(file_exists('storage/users/' . $imageTemp))
                {
                    unlink('storage/users/' . $imageTemp);
                }
            }
        }

        $this->resetUI();
        $this->emit('user-updated', 'Usuario actualizado');

    }

    public function destroy(User $user)
    {
        if($user)
        {
            $sales = Sales::where('user_id', $user->id)->count();
            if($sales > 0) {
                $this->emit('user-withsales', 'El usuario no se puede eliminar porque tiene ventas registradas');
            } else {
                $user->delete();
                $this->emit('user-delete', 'Usuario eliminado');
            }
        }        
    }

}
