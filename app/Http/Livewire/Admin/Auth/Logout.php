<?php

namespace App\Http\Livewire\Admin\Auth;

use Livewire\Component;

class Logout extends Component
{
    public function mount()
    {
        auth()->logout();
        return redirect()->to(route('admin.login'));
    }
}
