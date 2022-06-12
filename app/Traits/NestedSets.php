<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Kalnoy\Nestedset\NodeTrait;

trait NestedSets
{
    use NodeTrait;

    public function getLftName(): string
    {
        return 'lft';
    }

    public function getRgtName(): string
    {
        return 'rgt';
    }

    public function getParentIdName(): string
    {
        return 'parent_id';
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function breadcrumbs(): Collection
    {
        return $this->getAncestors()->add($this);
    }

    public function getTextPathAttribute(): string
    {
        return implode(' > ', $this->breadcrumbs()->pluck('name')->all());
    }

    public function updatePath(): void
    {
        foreach (supportedLocales() as $locale) {
            $nodes = $this->breadcrumbs()->pluck('translations.slug.' . $locale)->all();
            $this->setTranslation('path', $locale, implode('/', $nodes));
            $this->save();
        }
        foreach ($this->children() as $node) {
            $node->updatePath();
        }
    }

    public static function asTextTree($rootId = null, $exceptId = null, $displayedProperty = 'textPath')
    {
        $query = static::query();
        if ($rootId) {
            $query->whereDescendantOrSelf($rootId);
        }
        if ($exceptId) {
            $query->whereNotDescendantOf($exceptId);
            $query->where('id', '!=', $exceptId);
        }
        return $query->get()
            ->pluck($displayedProperty, 'id')
            ->sort()
            ->all();
    }
}
