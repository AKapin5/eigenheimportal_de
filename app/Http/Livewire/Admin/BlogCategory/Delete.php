<?php

namespace App\Http\Livewire\Admin\BlogCategory;

use App\Models\BlogCategory;
use Livewire\Component;

class Delete extends Component
{
    public function mount(BlogCategory $blogCategory)
    {
        $blogCategory->delete();
        return redirect()->to(request('_return') ?: route( 'admin.blog-categories.index'));
    }
}
