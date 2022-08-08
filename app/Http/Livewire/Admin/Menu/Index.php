<?php

namespace App\Http\Livewire\Admin\Menu;

use App\Http\Livewire\Admin\Base\BaseComponent;
use App\Models\Menu;

class Index extends BaseComponent
{
    public ?Menu $parent;

    protected $listeners = ['onDelete'];

    public function onDelete($params)
    {
        Menu::findOrFail($params['id'])->delete();
        return redirect()->to($params['_return'] ?: route( 'admin.menus.index'));
    }

    public function mount()
    {
        $this->parent = Menu::find(request('parent_id'));
    }
}
