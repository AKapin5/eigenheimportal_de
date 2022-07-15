<?php

namespace App\Repositories;

use App\Models\Apartment;
use Illuminate\Database\Eloquent\Collection;

class ApartmentRepository
{
    public function getTop(): Collection|array
    {
        return Apartment::query()
            ->where('is_top', 1)
            ->orderBy('id', 'desc')
            ->limit(3)
            ->get();
    }
}
