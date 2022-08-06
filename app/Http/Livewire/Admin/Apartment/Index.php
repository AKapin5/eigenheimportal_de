<?php

namespace App\Http\Livewire\Admin\Apartment;

use App\Http\Livewire\Admin\Base\BaseComponent;
use App\Models\ApartmentCategory;

class Index extends BaseComponent
{
    public ?ApartmentCategory $category;

    public function mount()
    {
        $this->category = ApartmentCategory::find(request()->get('category_id'));
    }
}
