<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $text
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Feedback extends Model
{
    use HasFactory;

    public $fillable = [
        'name', 'email', 'text',
    ];
}
