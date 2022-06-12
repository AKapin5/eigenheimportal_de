<?php

namespace App\Traits;

/**
 * @property string $role
 */
trait HasRoles
{
    use \Spatie\Permission\Traits\HasRoles;

    /**
     * @return string
     */
    public function getRoleAttribute(): string
    {
        return $this->getRoleNames()[0] ?? '';
    }

    /**
     * @param $role
     */
    public function setRoleAttribute($role): void
    {
        $oldRole = $this->getRoleAttribute();
        if ($oldRole) {
            $this->removeRole($oldRole);
        }
        $this->assignRole([$role]);
    }
}
