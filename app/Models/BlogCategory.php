<?php

namespace App\Models;


use App\Traits\HasOptions;
use App\Traits\HasTranslations;
use App\Traits\LocalizedLinks;
use App\Traits\NestedSets;
use App\Traits\Sortable;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $lgt
 * @property int $rgt
 * @property int $parent_id
 * @property string $name
 * @property string $path
 * @property string $alias
 * @property string $seo_title
 * @property string $seo_keywords
 * @property string $seo_description
 * @property int $status
 *
 * @property string $statusText
 * @property Blog[] $blogs
 * @mixin Eloquent
 */
class BlogCategory extends Model
{
    use HasTranslations;
    use Sortable;
    use HasOptions;
    use LocalizedLinks;
    use NestedSets;

    /**
     * @var string[]
     */
    public $translatable = [
        'name', 'alias', 'path', 'seo_title', 'seo_keywords', 'seo_description',
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
        'seo_title',
        'seo_keywords',
        'seo_description',
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

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
    public function blogs(): HasMany
    {
        return $this->hasMany(Blog::class, 'category_id', 'id');
    }

    /**
     * @param string $locale
     * @param bool $absolute
     * @return string|null
     */
    public function getLink(string $locale = '', bool $absolute = false): ?string
    {
        return route('blog.index', ['category' => $this->getTranslatedOrDefault('alias', $locale)], $absolute, $locale);
    }
}
