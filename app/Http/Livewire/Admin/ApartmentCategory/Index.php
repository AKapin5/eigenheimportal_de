<?php

namespace App\Http\Livewire\Admin\ApartmentCategory;

use App\Http\Livewire\Admin\Base\BaseComponent;
use App\Models\ApartmentCategory;

class Index extends BaseComponent
{
    public ?ApartmentCategory $parent;

    public function mount()
    {
        $this->parent = ApartmentCategory::find(request('parent_id'));
    }
}
