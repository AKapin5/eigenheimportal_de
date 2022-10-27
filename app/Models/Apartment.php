<?php

namespace App\Models;

use App\Traits\HasOptions;
use App\Traits\HasTranslations;
use App\Traits\LocalizedLinks;
use App\Traits\UploadsMedia;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
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
 * @property double $price
 * @property double $living_space
 * @property int $construction_year
 * @property int $rooms_count
 * @property int $heating
 * @property int $airport_travel_time
 * @property int $highway_travel_time
 * @property int $hospital_travel_time
 * @property int $school_travel_time
 * @property string $location_map
 * @property string $location_address
 * @property string $contact_phone
 * @property string $contact_email
 * @property string $contact_website
 * @property int $status
 * @property int $is_top
 * @property int $is_reference
 *
 * @property ApartmentCategory $category
 * @property string $statusText
 * @property string $isTopText
 * @mixin Eloquent
 *
 * @method static ofCategory(ApartmentCategory $category, bool $descendants = true)
 */
class Apartment extends Model implements HasMedia
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
        'is_reference',
        'name',
        'alias',
        'short_text',
        'description',
        'seo_title',
        'seo_keywords',
        'seo_description',
        'price',
        'living_space',
        'construction_year',
        'rooms_count',
        'heating',
        'airport_travel_time',
        'highway_travel_time',
        'hospital_travel_time',
        'school_travel_time',
        'contact_phone',
        'contact_email',
        'contact_website',
        'location_address',
        'location_map',
        'youtube_video',
    ];

    /**
     * @var string[]
     */
    protected $optionsFields = [
        'status',
        'heating',
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
    public static function getHeatingOptions(): array
    {
        return [
            __('Forced Air'),
            __('Electric'),
            __('Geothermal'),
            __('Radiant'),
            __('Steam Radiant'),
            __('Gas'),
            __('Wärmepumpe'),
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
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ApartmentCategory::class, 'category_id', 'id');
    }

    /**
     * @param Builder $query
     * @param ApartmentCategory $category
     * @param bool $descendants
     * @return Builder
     */
    public function scopeOfCategory(Builder $query, ApartmentCategory $category, bool $descendants = true): Builder
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
        return route('apartment.show', [
            'path' => $this->category->getTranslatedOrDefault('path', $locale),
            'alias' => $this->getTranslatedOrDefault('alias', $locale),
        ], $absolute, $locale);
    }
}
