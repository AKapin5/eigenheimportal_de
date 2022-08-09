<?php

namespace App\Http\Livewire\Admin\Menu;

use App\Http\Livewire\Admin\Base\AdminForm;
use App\Models\Menu;
use Livewire\WithFileUploads;

class Form extends AdminForm
{
    use WithFileUploads;

    public Menu $menu;

    public $statusOptions = [];

    public $menuOptions = [];

    public function rules(): array
    {
        return [
            'menu.title' => 'required|max:255',
            'menu.url' => 'max:255',
            'menu.status' => 'boolean',
            'menu.sort' => 'integer|nullable',
            'menu.parent_id' => 'integer|nullable',
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'menu.title' => __('Title'),
            'menu.url' => __('URL'),
            'menu.parent_id' => __('Parent'),
            'menu.status' => __('Show'),
            'menu.sort' => __('Sort'),
        ];
    }

    public function multilingual(): array
    {
        return [
            'menu.title',
            'menu.url',
        ];
    }

    public function mount(Menu $menu)
    {
        if (!$menu->exists) {
            $menu->status = 1;
            $menu->parent_id = request('parent_id');
        }
        $this->menu = $menu;
        $this->statusOptions = Menu::getStatusOptions();
        $this->menuOptions = $menu->asTextTree(null, $menu->id);
    }

    public function store()
    {
        $this->validate();
        if (!isset($this->menu->sort)) {
            $this->menu->assignNewSort();
        }
        if ($this->menu->save()) {
            $alert = [
                'messageType' => 'success',
                'messageText' => __('All changes are saved.'),
            ];
            if (!$this->_stay) {
                return redirect($this->_return ?: route("admin.menus.index"));
            }
        } else {
            $alert = [
                'messageType' => 'danger',
                'messageText' => __('An error occurred.'),
            ];
        }
        return redirect(route('admin.menus.edit', ['menu' => $this->menu->id, '_return' => $this->_return]))
            ->with($alert);
    }
}
