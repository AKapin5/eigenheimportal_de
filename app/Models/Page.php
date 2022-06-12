<?php

namespace App\Models;

use App\Traits\HasAliases;
use App\Traits\HasOptions;
use App\Traits\UploadsMedia;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;
use Spatie\MediaLibrary\HasMedia;

/**
 * @property int $id
 * @property string $name
 * @property string $alias
 * @property string $content
 * @property string $seo_title
 * @property string $seo_description
 * @property string $seo_keywords
 * @property int $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property string $statusText
 * @mixin Eloquent
 */
class Page extends Model implements HasMedia
{
    use HasTranslations;
    use HasOptions;
    use HasAliases;
    use UploadsMedia;

    /**
     * @var string[]
     */
    public $translatable = [
        'name', 'alias', 'content', 'seo_title', 'seo_description', 'seo_keywords'
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'name', 'content', 'alias', 'status', 'seo_title', 'seo_description', 'seo_keywords',
    ];

    /**
     * @var string[]
     */
    protected $optionsFields = [
        'status'
    ];

    /**
     * @return array
     */
    public static function getStatusOptions(): array
    {
        return [
            __('Не отображать'),
            __('Отображать'),
        ];
    }
}
