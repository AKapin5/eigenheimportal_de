<?php

namespace App\Models;

use App\Traits\HasOptions;
use App\Traits\HasTranslations;
use App\Traits\NestedSets;
use App\Traits\Sortable;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property integer $id
 * @property integer $lft
 * @property integer $rgt
 * @property integer $parent_id
 * @property string $name
 * @property string $alias
 * @property string $path
 * @property string $description
 * @property string $seo_title
 * @property string $seo_keywords
 * @property string $seo_description
 *
 * @property string $statusText
 * @mixin Eloquent
 */
class ApartmentCategory extends Model
{
    use HasTranslations;
    use Sortable;
    use HasOptions;
    use NestedSets;

    /**
     * @var string[]
     */
    public $translatable = [
        'name', 'alias', 'path', 'description', 'seo_title', 'seo_keywords', 'seo_description',
    ];

    /**
     * @var string[]
     */
    protected $optionsFields = [
        'status',
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'parent_id', 'sort', 'status', 'name', 'alias', 'description', 'seo_title', 'seo_keywords', 'seo_description',
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return Builder
     */
    protected function getAssignNewSortQuery(): Builder
    {
        return $this::query()
            ->where('parent_id', $this->parent_id);
    }

    /**
     * @return array
     */
    public static function getStatusOptions(): array
    {
        return [
            __('No'),
            __('Yes'),
        ];
    }

    /**
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(static::class, 'parent_id', 'id')->orderBy('sort');
    }

    /**
     * @return BelongsTo
     */
    public function getParent(): BelongsTo
    {
        return $this->belongsTo(static::class, 'id', 'parent_id');
    }
}
