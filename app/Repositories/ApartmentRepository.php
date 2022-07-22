<?php

namespace App\Repositories;

use App\Models\Apartment;
use App\Models\ApartmentCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ApartmentRepository
{
    public function getTop(): Collection
    {
        return Apartment::query()
            ->where('status', 1)
            ->where('is_top', 1)
            ->orderBy('id', 'desc')
            ->limit(3)
            ->get();
    }

    public function getCategories(ApartmentCategory $parent = null): Builder
    {
        return ApartmentCategory::query()
            ->where('status', 1)
            ->where('parent_id', $parent->id ?? null);
    }

    public function getApartments(ApartmentCategory $parent = null): Builder
    {
        return Apartment::query()
            ->where('status', 1)
            ->where('category_id', $parent->id ?? null);
    }

    public function findCategory($path): ApartmentCategory
    {
        return ApartmentCategory::where('path->' . app()->getLocale(), $path)
            ->firstOrFail();
    }

    public function findApartment($path, $alias): Apartment|Model
    {
        return Apartment::query()
            ->with('category')
            ->whereHas('category', function (Builder $query) use ($path) {
                $query->where('path->' . app()->getLocale(), $path);
            })
            ->where('alias->' . app()->getLocale(), $alias)
            ->firstOrFail();
    }
}
