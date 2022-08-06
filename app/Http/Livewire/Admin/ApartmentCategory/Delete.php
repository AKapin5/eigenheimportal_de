<?php

namespace App\Http\Livewire\Admin\ApartmentCategory;

use App\Models\ApartmentCategory;
use Livewire\Component;

class Delete extends Component
{
    public function mount(ApartmentCategory $apartmentCategory)
    {
        $apartmentCategory->delete();
        return redirect()->to(request('_return') ?: route( 'admin.apartment-categories.index'));
    }
}
