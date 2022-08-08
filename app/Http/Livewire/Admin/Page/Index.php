<?php

namespace App\Http\Livewire\Admin\Page;

use App\Http\Livewire\Admin\Base\BaseComponent;
use App\Models\Page;

class Index extends BaseComponent
{
    protected $listeners = ['onDelete'];

    public function onDelete($params)
    {
        Page::findOrFail($params['id'])->delete();
        return redirect()->to($params['_return'] ?: route( 'admin.pages.index'));
    }
}
