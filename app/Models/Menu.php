<?php

namespace App\Models;

use App\Traits\HasOptions;
use App\Traits\HasTranslations;
use App\Traits\Sortable;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $parent_id
 * @property string $title
 * @property string $url
 * @property int $status
 * @property int $sort
 *
 * @property string $statusText
 * @mixin Eloquent
 */
class Menu extends Model
{
    use HasTranslations;
    use Sortable;
    use HasOptions;

    /**
     * @var string[]
     */
    public $translatable = [
        'title', 'url',
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
        'title', 'url', 'status', 'sort', 'parent_id'
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
     * @param $type
     * @param $parent_id
     * @return Collection
     */
    public static function getItems($type, $parent_id = null): Collection
    {
        return static::query()
            ->where('parent_id', $parent_id)
            ->orderBy('sort')
            ->get();
    }

    /**
     * @param null $locale
     * @return string
     */
    public function getLink($locale = null) :string
    {
        return localizeUrl($this->url, $locale);
    }
}
