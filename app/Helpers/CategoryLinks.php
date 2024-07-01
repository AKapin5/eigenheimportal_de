<?php

namespace App\Helpers;

class CategoryLinks
{
    /**
     * @return array[]
     */
    public function buildMenu(): array
    {
        $links = [
            [
                'path' => '',
                'name' => __('Alle Objekte'),
                'icon' => 'objects',
            ],
            [
                'path' => 'wohnung',
                'name' => __('Wohnobjekte'),
                'icon' => 'haus',
            ],
            [
                'path' => 'gewerbe',
                'name' => __('Gewerbeobjekte'),
                'icon' => 'gewerbe',
            ],
            [
                'path' => 'gewerbe/hotel',
                'name' => __('Hotels'),
                'icon' => 'hotel',
            ],
        ];

        foreach ($links as &$link) {
            $link['active'] = request()->route()->parameter('path') == $link['path'];
        }

        return $links;
    }
}
