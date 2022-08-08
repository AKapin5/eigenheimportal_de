<?php

namespace App\Http\Livewire\Admin\Apartment;

use App\Http\Livewire\Admin\Base\BaseComponent;
use App\Models\Apartment;
use App\Models\ApartmentCategory;

class Index extends BaseComponent
{
    public ?ApartmentCategory $category;

    protected $listeners = ['onDelete'];

    public function onDelete($params)
    {
        Apartment::findOrFail($params['id'])->delete();
        return redirect()->to($params['_return'] ?: route('admin.apartments.index'));
    }

    public function mount()
    {
        $this->category = ApartmentCategory::find(request()->get('category_id'));
    }
}
