<?php

namespace App\Http\Livewire\Admin\User;

use App\Models\User;
use Livewire\Component;

class Delete extends Component
{
    public function mount(User $user)
    {
        $user->delete();
        return redirect()->to(request('_return') ?: route( 'admin.users.index'));
    }
}
