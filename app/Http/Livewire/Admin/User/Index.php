<?php

namespace App\Http\Livewire\Admin\User;

use App\Http\Livewire\Admin\Base\BaseComponent;
use App\Models\User;

class Index extends BaseComponent
{
    protected $listeners = ['onDelete'];

    public function onDelete($params)
    {
        User::findOrFail($params['id'])->delete();
        return redirect()->to($params['_return'] ?: route( 'admin.users.index'));
    }
}
