<?php

namespace App\Http\Livewire\Admin\BlogCategory;

use App\Http\Livewire\Admin\Base\AdminForm;
use App\Models\BlogCategory;
use CodeZero\UniqueTranslation\UniqueTranslationRule;
use Livewire\WithFileUploads;

class Form extends AdminForm
{
    use WithFileUploads;

    public BlogCategory $blogCategory;

    public $categoryOptions;

    public function rules(): array
    {
        return [
            'blogCategory.name' => 'required|max:255',
            'blogCategory.alias' => [
                'required',
                'max:255',
                UniqueTranslationRule::for('blog_categories', 'alias')->ignore($this->blogCategory->id)
            ],
            'blogCategory.sort' => 'integer|nullable',
            'blogCategory.parent_id' => 'integer|nullable',
            'blogCategory.seo_title' => 'nullable',
            'blogCategory.seo_description' => 'nullable',
            'blogCategory.seo_keywords' => 'nullable',
            'blogCategory.status' => 'boolean',
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'blogCategory.name' => __('Name'),
            'blogCategory.alias' => __('Alias'),
            'blogCategory.seo_title' => __('Seo title'),
            'blogCategory.seo_keywords' => __('Seo keywords'),
            'blogCategory.seo_description' => __('Seo description'),
            'blogCategory.parent_id' => __('Parent'),
            'blogCategory.sort' => __('Sort'),
        ];
    }

    public function multilingual(): array
    {
        return [
            'blogCategory.name',
            'blogCategory.alias',
            'blogCategory.seo_title',
            'blogCategory.seo_description',
            'blogCategory.seo_keywords',
        ];
    }

    public function slugs(): array
    {
        return [
            'blogCategory' => [
                ['name' => 'alias']
            ],
        ];
    }

    public function mount(BlogCategory $blogCategory)
    {
        if (!$blogCategory->exists) {
            $blogCategory->status = 1;
            $blogCategory->parent_id = request('parent_id');
        }
        $this->blogCategory = $blogCategory;
        $this->categoryOptions = $blogCategory->asTextTree(null, $blogCategory->id);
    }

    public function store()
    {
        $this->validate();
        if (!isset($this->apartmentCategory->sort)) {
            $this->blogCategory->assignNewSort();
        }
        if ($this->blogCategory->save()) {
            $this->blogCategory->updatePath();
            $alert = [
                'messageType' => 'success',
                'messageText' => __('All changes are saved.'),
            ];
            if (!$this->_stay) {
                return redirect($this->_return ?: route("admin.blog-categories.index"));
            }
        } else {
            $alert = [
                'messageType' => 'danger',
                'messageText' => __('An error occurred.'),
            ];
        }
        return redirect(route('admin.blog-categories.edit', ['blogCategory' => $this->blogCategory->id, '_return' => $this->_return]))
            ->with($alert);
    }
}
