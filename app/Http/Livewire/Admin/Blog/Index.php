<?php

namespace App\Http\Livewire\Admin\Blog;

use App\Http\Livewire\Admin\Base\BaseComponent;
use App\Models\BlogCategory;

class Index extends BaseComponent
{
    public ?BlogCategory $category;

    public function mount()
    {
        $this->category = BlogCategory::find(request()->get('category_id'));
    }
}
