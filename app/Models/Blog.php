<?php

namespace App\Models;

use App\Interfaces\HasComments;
use App\Traits\HasOptions;
use App\Traits\HasTranslations;
use App\Traits\LocalizedLinks;
use App\Traits\UploadsMedia;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;

/**
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property string $alias
 * @property string $description
 * @property string $seo_title
 * @property string $seo_keywords
 * @property string $seo_description
 * @property int $status
 *
 * @property BlogCategory $category
 * @property string $statusText
 * @property string $isTopText
 * @mixin Eloquent
 *
 */
class Blog extends Model implements HasMedia, HasComments
{
    use HasTranslations;
    use HasOptions;
    use UploadsMedia;
    use LocalizedLinks;

    /**
     * @var string[]
     */
    public $translatable = [
        'name', 'alias', 'short_text', 'description', 'seo_title', 'seo_keywords', 'seo_description',
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'category_id',
        'status',
        'is_top',
        'name',
        'alias',
        'short_text',
        'description',
        'seo_title',
        'seo_keywords',
        'seo_description',
    ];


    /**
     * @var string[]
     */
    protected $optionsFields = [
        'status',
        'is_top',
    ];

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
     * @return array
     */
    public static function getIsTopOptions(): array
    {
        return [
            __('No'),
            __('Yes'),
        ];
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 1);
    }

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'category_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'entity_id', 'id')
            ->where('entity_class', Blog::class)
            ->orderBy('created_at', 'desc');
    }

    /**
     * @param Builder $query
     * @param BlogCategory $category
     * @param bool $descendants
     * @return Builder
     */
    public function scopeOfCategory(Builder $query, BlogCategory $category, bool $descendants = true): Builder
    {
        if ($descendants) {
            $descendantIds = $category->descendants()->get(['id'])->toArray();
            return $query->whereIn('category_id', array_merge($descendantIds, [$category->id]));
        } else {
            return $query->where('category_id', $category->id);
        }
    }

    /**
     * @param string $locale
     * @param bool $absolute
     * @return string|null
     */
    public function getLink(string $locale = '', bool $absolute = false): ?string
    {
        return route('blog.show', [
            'category' => $this->category->getTranslatedOrDefault('alias', $locale),
            'alias' => $this->getTranslatedOrDefault('alias', $locale),
        ], $absolute, $locale);
    }
}

