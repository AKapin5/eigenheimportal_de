<?php

namespace App\Models;

use App\Traits\HasOptions;
use App\Traits\HasTranslations;
use App\Traits\LocalizedLinks;
use App\Traits\NestedSets;
use App\Traits\Sortable;
use App\Traits\UploadsMedia;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;

/**
 * @property int $id
 * @property int $lft
 * @property int $rgt
 * @property int $parent_id
 * @property string $name
 * @property string $alias
 * @property string $path
 * @property string $description
 * @property string $seo_title
 * @property string $seo_keywords
 * @property string $seo_description
 * @property int $sort
 * @property int $status
 *
 * @property string $statusText
 * @property ApartmentCategory $parent
 * @property ApartmentCategory[] $children
 * @property Apartment[] $apartments
 * @mixin Eloquent
 */
class ApartmentCategory extends Model implements HasMedia
{
    use HasTranslations;
    use Sortable;
    use HasOptions;
    use NestedSets;
    use UploadsMedia;
    use LocalizedLinks;

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
        'parent_id',
        'sort',
        'status',
        'name',
        'alias',
        'description',
        'seo_title',
        'seo_keywords',
        'seo_description',
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
     * @return HasMany
     */
    public function activeChildren(): HasMany
    {
        return $this->children()->where('status', 1);
    }

    /**
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(static::class, 'parent_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function apartments(): HasMany
    {
        return $this->hasMany(Apartment::class, 'category_id', 'id');
    }

    /**
     * @param string $locale
     * @param bool $absolute
     * @return string|null
     */
    public function getLink(string $locale = '', bool $absolute = false): ?string
    {
        return route('apartment.index', ['path' => $this->getTranslatedOrDefault('path', $locale)], $absolute, $locale);
    }
}
