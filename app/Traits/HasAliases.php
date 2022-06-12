<?php


namespace App\Traits;

use Carbon\Carbon;

trait HasAliases
{
    /**
     * @param $value
     */
    public function setAliasAttribute($value)
    {
        $this->attributes['alias'] = empty($value) ? null : mb_strtolower($value);
    }

    /**
     * @return bool
     */
    public function canEditAlias(): bool
    {
        $created = $this->created_at;
        $now = Carbon::now();
        return $created->diff($now)->days <= 14;
    }
}
