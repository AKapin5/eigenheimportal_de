<?php

namespace App\Http\Livewire\Admin\Apartment;

use App\Models\Apartment;
use Livewire\Component;

class Delete extends Component
{
    public function mount(Apartment $apartment)
    {
        $apartment->delete();
        return redirect()->to(request('_return') ?: route( 'admin.apartments.index'));
    }
}
