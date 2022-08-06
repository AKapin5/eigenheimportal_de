<?php

namespace App\Http\Livewire\Admin\BlogCategory;

use App\Http\Livewire\Admin\Base\BaseComponent;
use App\Models\BlogCategory;

class Index extends BaseComponent
{
    public ?BlogCategory $parent;

    public function mount()
    {
        $this->parent = BlogCategory::find(request('parent_id'));
    }
}
