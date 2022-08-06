<?php

namespace App\Http\Livewire\Admin\Menu;

use App\Http\Livewire\Admin\Base\BaseComponent;
use App\Models\Menu;

class Index extends BaseComponent
{
    public ?Menu $parent;

    public function mount()
    {
        $this->parent = Menu::find(request('parent_id'));
    }
}
