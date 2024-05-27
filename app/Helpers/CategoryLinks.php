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
                'name' => __('All Objekte'),
                'icon' => 'objects',
            ],
            [
                'path' => 'wohnung',
                'name' => __('Wohnungen'),
                'icon' => 'wohnung',
            ],
            [
                'path' => 'haus',
                'name' => __('Häuser'),
                'icon' => 'haus',
            ],
            [
                'path' => 'gewerbe',
                'name' => __('Gewerbe'),
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
