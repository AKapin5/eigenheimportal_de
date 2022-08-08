<?php

namespace App\Http\Livewire\Admin\Blog;

use App\Http\Livewire\Admin\Base\BaseComponent;
use App\Models\Blog;
use App\Models\BlogCategory;

class Index extends BaseComponent
{
    public ?BlogCategory $category;

    protected $listeners = ['onDelete'];

    public function onDelete($params)
    {
        Blog::findOrFail($params['id'])->delete();
        return redirect()->to($params['_return'] ?: route('admin.blogs.index'));
    }

    public function mount()
    {
        $this->category = BlogCategory::find(request()->get('category_id'));
    }
}
