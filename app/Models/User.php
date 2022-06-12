<?php

namespace App\Models;

use App\Traits\HasOptions;
use App\Traits\HasRoles;
use App\Traits\UploadsMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Eloquent;
use Spatie\MediaLibrary\HasMedia;
use Str;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $email_verified_at
 * @property string $password
 * @property string $remember_token
 * @property integer $status
 * @property string $api_token
 * @property integer $created_at
 * @property integer $updated_at
 * @mixin Eloquent
 */
class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, HasOptions, UploadsMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'status',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @var string[]
     */
    protected array $optionsFields = [
        'status'
    ];

    /**
     * @return void
     */
    public function generateToken(): void
    {
        $this->api_token = Str::random(60);
    }

    /**
     * @return array
     */
    public static function getStatusOptions() : array
    {
        return [
            __('Inactive'),
            __('Active'),
        ];
    }

    /**
     * @return string
     */
    public function getStatusText() : string
    {
        $options = self::getStatusOptions();
        return $options[$this->status] ?? '';
    }
}
