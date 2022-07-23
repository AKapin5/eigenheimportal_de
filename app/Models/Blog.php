<?php

namespace App\Models;

use App\Traits\HasOptions;
use App\Traits\HasTranslations;
use App\Traits\LocalizedLinks;
use App\Traits\UploadsMedia;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
 * @mixin Eloquent
 *
 */
class Blog extends Model implements HasMedia
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
        'category_id', 'status', 'name', 'alias',
        'short_text', 'description', 'seo_title', 'seo_keywords', 'seo_description',
    ];


    /**
     * @var string[]
     */
    protected $optionsFields = [
        'status',
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
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'category_id', 'id');
    }

    /**
     * @param string $locale
     * @param bool $absolute
     * @return string|null
     */
    public function getLink(string $locale = '', bool $absolute = false): ?string
    {
        return route('apartment.show', [
            'category' => $this->category->getTranslatedOrDefault('alias', $locale),
            'alias' => $this->getTranslatedOrDefault('alias', $locale),
        ], $absolute, $locale);
    }
}

