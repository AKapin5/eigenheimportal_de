<?php

namespace App\Http\Livewire\Admin\ApartmentCategory;

use App\Http\Livewire\Admin\Base\BaseComponent;
use App\Models\ApartmentCategory;

class Index extends BaseComponent
{
    public ?ApartmentCategory $parent;

    protected $listeners = ['onDelete'];

    public function onDelete($params)
    {
        ApartmentCategory::findOrFail($params['id'])->delete();
        return redirect()->to($params['_return'] ?: route('admin.apartment-categories.index'));
    }

    public function mount()
    {
        $this->parent = ApartmentCategory::find(request('parent_id'));
    }
}
