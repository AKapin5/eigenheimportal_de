<?php

namespace App\Http\Livewire\Admin\Blog;

use App\Http\Livewire\Admin\Base\AdminForm;
use App\Models\Blog;
use App\Models\BlogCategory;
use CodeZero\UniqueTranslation\UniqueTranslationRule;
use Livewire\WithFileUploads;

class Form extends AdminForm
{
    use WithFileUploads;

    public Blog $blog;

    public $photo;

    public $categoryOptions = [];

    public function rules(): array
    {
        return [
            'blog.name' => 'required|max:255',
            'blog.alias' => [
                'required',
                'max:255',
                UniqueTranslationRule::for('blogs', 'alias')->ignore($this->blog->id)
            ],
            'blog.category_id' => 'integer|nullable|required',
            'blog.status' => 'boolean',
            'blog.is_top' => 'boolean',
            'blog.short_text' => 'max:400',
            'blog.description' => 'max:50000',
            'blog.seo_title' => 'max:255',
            'blog.seo_keywords' => 'max:50000',
            'blog.seo_description' => 'max:50000',
            'photo' => 'image|nullable',
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'blog.name' => __('Name'),
            'blog.alias' => __('Alias'),
            'blog.short_text' => __('Short text'),
            'blog.description' => __('Description'),
            'blog.seo_title' => __('Seo title'),
            'blog.seo_keywords' => __('Seo keywords'),
            'blog.seo_description' => __('Seo description'),
            'blog.category_id' => __('Category'),
            'blog.status' => __('Show'),
            'blog.is_top' => __('Is top'),
            'photo' => __('Photo'),
        ];
    }

    public function multilingual(): array
    {
        return [
            'blog.name',
            'blog.alias',
            'blog.short_text',
            'blog.description',
            'blog.seo_title',
            'blog.seo_description',
            'blog.seo_keywords',
        ];
    }

    public function slugs(): array
    {
        return [
            'blog' => [
                ['name' => 'alias']
            ],
        ];
    }

    public function mount(Blog $blog)
    {
        if (!$blog->exists) {
            $blog->status = 1;
            $blog->category_id = request('category_id');
        }
        $this->blog = $blog;
        $this->categoryOptions = BlogCategory::asTextTree();
    }

    public function store()
    {
        $this->validate();
        if ($this->blog->save()) {
            $this->saveMedia($this->blog, 'photo');
            $alert = [
                'messageType' => 'success',
                'messageText' => __('All changes are saved.'),
            ];
            if (!$this->_stay) {
                return redirect($this->_return ?: route("admin.blogs.index"));
            }
        } else {
            $alert = [
                'messageType' => 'danger',
                'messageText' => __('An error occurred.'),
            ];
        }
        return redirect(route('admin.blogs.edit', ['blog' => $this->blog->id, '_return' => $this->_return]))
            ->with($alert);
    }
}
