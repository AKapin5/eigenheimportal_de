<?php

namespace App\Http\Livewire\Admin\Menu;

use App\Models\Menu;
use Livewire\Component;

class Delete extends Component
{
    public function mount(Menu $menu)
    {
        $menu->delete();
        return redirect()->to(request('_return') ?: route( 'admin.menus.index'));
    }
}
