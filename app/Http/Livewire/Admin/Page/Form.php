<?php

namespace App\Http\Livewire\Admin\Page;

use App\Http\Livewire\Admin\Base\AdminForm;
use App\Models\Page;
use CodeZero\UniqueTranslation\UniqueTranslationRule;
use Livewire\WithFileUploads;

class Form extends AdminForm
{
    use WithFileUploads;

    public Page $page;

    public $photo;

    public $attachments = [];

    public function rules(): array
    {
        return [
            'page.status' => 'boolean',
            'page.title' => 'required|max:255',
            'page.alias' => [
                'required',
                'max:255',
                UniqueTranslationRule::for('pages', 'alias')->ignore($this->page->id)
            ],
            'page.content' => 'required',
            'page.seo_title' => 'nullable',
            'page.seo_description' => 'nullable',
            'page.seo_keywords' => 'nullable',
            'photo' => 'image|nullable',
            'attachments.*' => 'image|nullable',
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'page.status' => __('Status'),
            'page.title' => __('Title'),
            'page.alias' => __('Alias'),
            'page.content' => __('Content'),
            'page.seo_title' => __('SEO Title'),
            'page.seo_description' => __('SEO Description'),
            'page.seo_keywords' => __('SEO Keywords'),
            'photo' => __('Photo'),
            'attachments.*' => __('Attachments'),
        ];
    }

    public function multilingual(): array
    {
        return [
            'page.title',
            'page.alias',
            'page.content',
            'page.seo_title',
            'page.seo_description',
            'page.seo_keywords',
        ];
    }

    public function slugs(): array
    {
        return [
            'page' => [
                ['title' => 'alias']
            ],
        ];
    }

    public function mount(Page $page)
    {
        if (!$page->exists) {
            $page->status = 1;
        }
        $this->page = $page;
    }

    public function store()
    {
        $this->validate();
        if ($this->page->save()) {
            $this->saveMedia($this->page, 'photo');
            $this->saveMedia($this->page, 'attachments');
            $alert = [
                'messageType' => 'success',
                'messageText' => __('All changes are saved.'),
            ];
            if (!$this->_stay) {
                return redirect($this->_return ?: route("admin.pages.index"));
            }
        } else {
            $alert = [
                'messageType' => 'danger',
                'messageText' => __('An error occurred.'),
            ];
        }
        return redirect(route('admin.pages.edit', ['page' => $this->page->id, '_return' => $this->_return]))
            ->with($alert);
    }
}
