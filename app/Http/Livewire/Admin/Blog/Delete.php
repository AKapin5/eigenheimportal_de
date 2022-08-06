<?php

namespace App\Http\Livewire\Admin\Blog;

use App\Models\Blog;
use Livewire\Component;

class Delete extends Component
{
    public function mount(Blog $blog)
    {
        $blog->delete();
        return redirect()->to(request('_return') ?: route( 'admin.blogs.index'));
    }
}
