<?php

namespace App\Repositories;

use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BlogRepository
{
    public function getTop(): Collection
    {
        return Blog::query()
            ->where('status', 1)
            ->where('is_top', 1)
            ->orderBy('id', 'desc')
            ->limit(3)
            ->get();
    }

    public function getCategories(): Builder
    {
        return BlogCategory::query()
            ->where('status', 1);
    }

    public function getBlogs(BlogCategory $parent = null): Builder
    {
        $query = Blog::query()
            ->where('status', 1)
            ->orderBy('id', 'desc');
        if ($parent) {
            $query->where('category_id', $parent->id);
        }
        return $query;
    }

    public function findCategory($alias): BlogCategory
    {
        return BlogCategory::where('alias->' . app()->getLocale(), $alias)
            ->firstOrFail();
    }

    public function findBlog($category, $alias): Blog|Model
    {
        return Blog::query()
            ->with('category')
            ->whereHas('category', function (Builder $query) use ($category) {
                $query->where('alias->' . app()->getLocale(), $category);
            })
            ->where('alias->' . app()->getLocale(), $alias)
            ->firstOrFail();
    }
}
