<?php

namespace App\Http\Livewire\Admin\User;

use App\Http\Livewire\Admin\Base\AdminForm;
use App\Models\User;
use Hash;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Role;

class Form extends AdminForm
{
    use WithFileUploads;

    public User $user;

    public $password_clean;

    public $roles = [];

    public $statusOptions = [];

    public $roleOptions = [];

    public function rules(): array
    {
        $rules = [
            'user.name' => 'required|max:255',
            'user.email' => [
                'required',
                'max:255',
                'email',
                Rule::unique('users', 'email')
                    ->ignore($this->user->id, 'id')
            ],
            'user.status' => 'boolean',
            'roles' => 'required',
            'roles.*' => 'nullable',
        ];
        if (!$this->user->exists) {
            $rules['password_clean'] = 'required';
        }
        return $rules;
    }

    public function validationAttributes(): array
    {
        return [
            'user.name' => __('Name'),
            'user.email' => __('Email'),
            'user.status' => __('Status'),
            'password_clean' => __('Password'),
            'roles' => __('Roles'),
        ];
    }

    public function mount(User $user)
    {
        if (!$user->exists) {
            $user->status = 1;
        }
        $this->user = $user;
        $this->roles = $user->roles()->pluck('name')->toArray();
        $this->statusOptions = User::getStatusOptions();
        $this->roleOptions = $this->getRoleOptions();
    }

    public function store()
    {
        $this->validate();
        if (!$this->user->exists) {
            $this->user->generateToken();
        }
        if ($this->password_clean) {
            $this->user->password = Hash::make($this->password_clean);
        }
        if ($this->user->save()) {
            $this->user->syncRoles($this->roles);
            $alert = [
                'messageType' => 'success',
                'messageText' => __('All changes are saved.'),
            ];
            if (!$this->_stay) {
                return redirect($this->_return ?: route("admin.users.index"));
            }
        } else {
            $alert = [
                'messageType' => 'danger',
                'messageText' => __('An error occurred.'),
            ];
        }
        return redirect(route('admin.users.edit', ['user' => $this->user->id, '_return' => $this->_return]))
            ->with($alert);
    }


    protected function getRoleOptions(): array
    {
        $query = Role::query();
        if (!$this->getIdentity()->hasRole('admin')) {
            $query->where('name', '!=', 'admin');
        }
        return $query->get()->pluck('name', 'name')->toArray();
    }


    protected function getIdentity(): User|Authenticatable|null
    {
        return auth()->user();
    }
}
