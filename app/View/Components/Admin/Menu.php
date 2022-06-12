<?php

namespace App\View\Components\Admin;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Menu extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View
     */
    public function render(): View
    {
        $menuItems = $this->getItems();
        $this->activate($menuItems);
        return view('components.admin.menu', compact('menuItems'));
    }

    /**
     * @return array
     */
    protected function getItems(): array
    {
        $prefix = config('admin.urlPrefix');
        return [
            [
                'url' => "/$prefix",
                'icon' => 'th',
                'label' => __('Главная'),
                'match' => 'admin.dashboard',
            ],

            [
                'url' => "/$prefix/pages",
                'icon' => 'file-alt',
                'label' => __('Страницы'),
                'match' => 'admin.pages.*',
            ],

            [
                'url' => "/$prefix/users",
                'icon' => 'user',
                'label' => __('Пользователи'),
                'match' => 'admin.users.*',
            ],
        ];
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
