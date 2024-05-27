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

    public function getApartments(ApartmentCategory $category = null): Builder
    {
        $query = Apartment::query()
            ->where('status', 1)
            ->orderBy('id', 'desc');

        if ($category) {
            $query->where(function (Builder $criteria) use ($category) {
                $criteria->where('category_id', $category->id);
                $criteria->orWhereIn('category_id', $category->getDescendants()->pluck('id'));
            });
        }
        return $query;
    }

    public function getReferences(): Builder
    {
        return Apartment::query()
            ->where('is_reference', 1)
            ->where('status', 1)
            ->orderBy('id', 'desc');
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
