<?php

namespace App\Http\Livewire\Admin\ApartmentCategory;

use App\Http\Livewire\Admin\Base\AdminForm;
use App\Models\ApartmentCategory;
use CodeZero\UniqueTranslation\UniqueTranslationRule;
use Livewire\WithFileUploads;

class Form extends AdminForm
{
    use WithFileUploads;

    public ApartmentCategory $apartmentCategory;

    public $photo;

    public $categoryOptions;

    public function rules(): array
    {
        return [
            'apartmentCategory.name' => 'required|max:255',
            'apartmentCategory.alias' => [
                'required',
                'max:255',
                UniqueTranslationRule::for('apartment_categories', 'alias')->ignore($this->apartmentCategory->id)
            ],
            'apartmentCategory.sort' => 'integer|nullable',
            'apartmentCategory.parent_id' => 'integer|nullable',
            'apartmentCategory.description' => 'required',
            'apartmentCategory.seo_title' => 'nullable',
            'apartmentCategory.seo_description' => 'nullable',
            'apartmentCategory.seo_keywords' => 'nullable',
            'apartmentCategory.status' => 'boolean',
            'photo' => 'image|nullable',
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'apartmentCategory.name' => __('Name'),
            'apartmentCategory.alias' => __('Alias'),
            'apartmentCategory.description' => __('Description'),
            'apartmentCategory.seo_title' => __('Seo title'),
            'apartmentCategory.seo_keywords' => __('Seo keywords'),
            'apartmentCategory.seo_description' => __('Seo description'),
            'apartmentCategory.parent_id' => __('Parent'),
            'apartmentCategory.sort' => __('Sort'),
            'photo' => __('Photo'),
        ];
    }

    public function multilingual(): array
    {
        return [
            'apartmentCategory.name',
            'apartmentCategory.alias',
            'apartmentCategory.description',
            'apartmentCategory.seo_title',
            'apartmentCategory.seo_description',
            'apartmentCategory.seo_keywords',
        ];
    }

    public function slugs(): array
    {
        return [
            'apartmentCategory' => [
                ['name' => 'alias']
            ],
        ];
    }

    public function mount(ApartmentCategory $apartmentCategory)
    {
        if (!$apartmentCategory->exists) {
            $apartmentCategory->status = 1;
            $apartmentCategory->parent_id = request('parent_id');
        }
        $this->apartmentCategory = $apartmentCategory;
        $this->categoryOptions = $apartmentCategory->asTextTree(null, $apartmentCategory->id);
    }

    public function store()
    {
        $this->validate();
        if (!isset($this->apartmentCategory->sort)) {
            $this->apartmentCategory->assignNewSort();
        }
        if ($this->apartmentCategory->save()) {
            $this->apartmentCategory->updatePath();
            $this->saveMedia($this->apartmentCategory, 'photo');
            $alert = [
                'messageType' => 'success',
                'messageText' => __('All changes are saved.'),
            ];
            if (!$this->_stay) {
                return redirect($this->_return ?: route("admin.apartment-categories.index"));
            }
        } else {
            $alert = [
                'messageType' => 'danger',
                'messageText' => __('An error occurred.'),
            ];
        }
        return redirect(route('admin.apartment-categories.edit', ['apartmentCategory' => $this->apartmentCategory->id, '_return' => $this->_return]))
            ->with($alert);
    }
}
