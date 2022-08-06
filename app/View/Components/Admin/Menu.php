<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class Menu extends Component
{
    public $menuItems;

    public function __construct()
    {
        $this->menuItems = $this->getItems();
    }

    public function render()
    {
        return view('components.admin.menu');
    }

    /**
     * @return array
     */
    protected function getItems(): array
    {
        $prefix = config('admin.urlPrefix');
        $menuItems = [
            [
                'url' => "/$prefix",
                'icon' => 'th',
                'label' => __('Dashboard'),
                'match' => 'admin.dashboard',
            ],

//            [
//                'url' => "/$prefix/pages",
//                'icon' => 'file-alt',
//                'label' => __('Pages'),
//                'match' => 'admin.pages.*',
//            ],

            [
                'url' => "/$prefix/apartments",
                'icon' => 'home',
                'label' => __('Apartments'),
                'items' => [
                    [
                        'url' => "/$prefix/apartment-categories",
                        'label' => __('Categories'),
                        'match' => 'admin.apartment-categories.*',
                    ],
                    [
                        'url' => "/$prefix/apartments",
                        'label' => __('Items'),
                        'match' => 'admin.apartments.*',
                    ],
                ],
            ],

            [
                'url' => "/$prefix/blogs",
                'icon' => 'newspaper',
                'label' => __('Blogs'),
                'items' => [
                    [
                        'url' => "/$prefix/blog-categories",
                        'label' => __('Categories'),
                        'match' => 'admin.blog-categories.*',
                    ],
                    [
                        'url' => "/$prefix/blogs",
                        'label' => __('Items'),
                        'match' => 'admin.blogs.*',
                    ],
                ],
            ],

            [
                'url' => "/$prefix/menus",
                'icon' => 'bars',
                'label' => __('Menu'),
                'match' => 'admin.menus.*',
            ],

            [
                'url' => "/$prefix/feedback",
                'icon' => 'phone',
                'label' => __('Feedback'),
                'match' => 'admin.feedback.*',
            ],


            [
                'url' => "/$prefix/users",
                'icon' => 'user',
                'label' => __('Users'),
                'match' => 'admin.users.*',
            ],
        ];
        $this->activate($menuItems);
        return $menuItems;
    }

    /**
     * @param $menuItems
     * @return bool
     */
    protected function activate(&$menuItems): bool
    {
        $hasActive = false;
        foreach ($menuItems as &$menuItem) {
            if (isset($menuItem['items'])) {
                $menuItem['active'] = self::activate($menuItem['items']);
            } else {
                $menuItem['active'] = isset($menuItem['match']) && request()->routeIs($menuItem['match']);
            }
            if ($menuItem['active']) {
                $hasActive = true;
            }
        }
        return $hasActive;
    }
}
