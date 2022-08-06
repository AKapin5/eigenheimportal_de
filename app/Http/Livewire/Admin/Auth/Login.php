<?php

namespace App\Http\Livewire\Admin\Auth;

use App\Http\Livewire\Admin\Base\BaseComponent;
use App\Models\User;

class Login extends BaseComponent
{
    public string $email = '';

    public string $password = '';

    public bool $remember = false;

    protected array $rules = [
        'email' => 'required|email:rfc,dns',
        'password' => 'required|min:6',
    ];

    public function mount()
    {
        if (auth()->user()) {
            return redirect()->intended(route('admin.dashboard'));
        }
    }

    public function login()
    {
        if (auth()->attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            $user = User::where(['email' => $this->email])->first();
            auth()->login($user, $this->remember);
            return redirect()->intended(route('admin.dashboard'));
        }
        return $this->addError('email', __('auth.failed'));
    }
}
