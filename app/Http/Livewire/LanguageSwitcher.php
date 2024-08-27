<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Route;

class LanguageSwitcher extends Component
{
    public $pageLinks = [];

    public function mount()
    {
        $pageLinks = view()->shared('pageLinks');
        if (!isset($pageLinks)) {
            foreach (supportedLocales() as $locale) {
                $routeParameters = Route::current()->parameters();
                $pageLinks[$locale] = route(Route::current()->getName(), $routeParameters, true, $locale);
            }
        }
        $this->pageLinks = $pageLinks;
    }
}
