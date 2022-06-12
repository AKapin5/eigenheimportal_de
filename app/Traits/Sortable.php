<?php

namespace App\Traits;


use Illuminate\Database\Eloquent\Builder;

trait Sortable
{
    protected function getAssignNewSortQuery(): Builder
    {
        return $this::query();
    }

    public function assignNewSort()
    {
        $this->sort = ($this->getAssignNewSortQuery()
                ->max('sort') ?: 0) + 100;
    }
}
