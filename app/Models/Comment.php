<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $entity_id
 * @property int $entity_class
 * @property int $name
 * @property int $text
 *
 * @mixin Eloquent
 */
class Comment extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'text',
        'entity_class',
    ];
}
