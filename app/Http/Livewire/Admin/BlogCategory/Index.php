<?php

namespace App\Http\Livewire\Admin\BlogCategory;

use App\Http\Livewire\Admin\Base\BaseComponent;
use App\Models\BlogCategory;

class Index extends BaseComponent
{
    public ?BlogCategory $parent;

    protected $listeners = ['onDelete'];

    public function onDelete($params)
    {
        BlogCategory::findOrFail($params['id'])->delete();
        return redirect()->to($params['_return'] ?: route('admin.blog-categories.index'));
    }

    public function mount()
    {
        $this->parent = BlogCategory::find(request('parent_id'));
    }
}
