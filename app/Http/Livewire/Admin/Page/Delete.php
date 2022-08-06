<?php

namespace App\Http\Livewire\Admin\Page;

use App\Models\Page;
use Livewire\Component;

class Delete extends Component
{
    public function mount(Page $page)
    {
        $page->delete();
        return redirect()->to(request('_return') ?: route( 'admin.pages.index'));
    }
}
