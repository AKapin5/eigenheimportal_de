<?php

namespace App\Http\Livewire\Admin\Base;

use Livewire\Component;

class BaseComponent extends Component
{
    public function renderToView()
    {
        $view = parent::renderToView();
        return $view?->layout('components.admin.layouts.master');
    }
}
