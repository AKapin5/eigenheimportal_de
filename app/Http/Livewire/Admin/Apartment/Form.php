<?php

namespace App\Http\Livewire\Admin\Apartment;

use App\Http\Livewire\Admin\Base\AdminForm;
use App\Models\Apartment;
use App\Models\ApartmentCategory;
use CodeZero\UniqueTranslation\UniqueTranslationRule;
use Livewire\WithFileUploads;

class Form extends AdminForm
{
    use WithFileUploads;

    public Apartment $apartment;

    public $photos = [];

    public $floor_plan;

    public $attachments = [];

    public $categoryOptions = [];

    public $heatingOptions = [];

    public function rules(): array
    {
        return [
            'apartment.name' => 'required|max:255',
            'apartment.alias' => [
                'required',
                'max:255',
                UniqueTranslationRule::for('apartments', 'alias')->ignore($this->apartment->id)
            ],
            'apartment.category_id' => 'integer|nullable|required',
            'apartment.status' => 'boolean',
            'apartment.is_top' => 'boolean',
            'apartment.is_reference' => 'boolean',
            'apartment.price' => 'numeric',
            'apartment.short_text' => 'max:400',
            'apartment.description' => 'max:50000',
            'apartment.seo_title' => 'max:255',
            'apartment.seo_keywords' => 'max:50000',
            'apartment.seo_description' => 'max:50000',
            'apartment.living_space' => 'numeric|nullable',
            'apartment.construction_year' => 'integer|nullable',
            'apartment.rooms_count' => 'integer|nullable',
            'apartment.heating' => 'integer|nullable',
            'apartment.airport_travel_time' => 'integer|nullable',
            'apartment.highway_travel_time' => 'integer|nullable',
            'apartment.hospital_travel_time' => 'integer|nullable',
            'apartment.school_travel_time' => 'integer|nullable',
            'apartment.contact_phone' => 'max:255|nullable',
            'apartment.contact_email' => 'max:255|nullable|email',
            'apartment.contact_website' => 'max:255|nullable',
            'apartment.location_map' => 'max:4000|nullable',
            'apartment.location_address' => 'nullable',
            'apartment.youtube_video' => 'max:4000',
            'floor_plan' => 'image|nullable',
            'photos.*' => 'image|nullable',
            'attachments.*' => 'file|nullable',
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'apartment.name' => __('Name'),
            'apartment.alias' => __('Alias'),
            'apartment.short_text' => __('Short text'),
            'apartment.description' => __('Description'),
            'apartment.seo_title' => __('Seo title'),
            'apartment.seo_keywords' => __('Seo keywords'),
            'apartment.seo_description' => __('Seo description'),
            'apartment.category_id' => __('Category'),
            'apartment.status' => __('Show'),
            'apartment.is_top' => __('Is top'),
            'apartment.is_reference' => __('Is reference'),
            'apartment.price' => __('Price'),
            'apartment.living_space' => __('Living space'),
            'apartment.construction_year' => __('Year of construction'),
            'apartment.rooms_count' => __('Rooms count'),
            'apartment.heating' => __('Heating'),
            'apartment.airport_travel_time' => __('Airport distance (min)'),
            'apartment.highway_travel_time' => __('Highway distance (min)'),
            'apartment.hospital_travel_time' => __('Hospital distance (min)'),
            'apartment.school_travel_time' => __('School distance (min)'),
            'apartment.contact_phone' => __('Contact phone'),
            'apartment.contact_email' => __('Contact e-mail'),
            'apartment.contact_website' => __('Contact website'),
            'apartment.location_map' => __('Location map'),
            'apartment.location_address' => __('Location address'),
            'apartment.youtube_video' => __('Youtube video'),
            'floor_plan' => __('Floor plan'),
            'photos.*' => __('Photos'),
            'attachments.*' => __('Attachments'),
        ];
    }

    public function multilingual(): array
    {
        return [
            'apartment.name',
            'apartment.alias',
            'apartment.short_text',
            'apartment.description',
            'apartment.seo_title',
            'apartment.seo_description',
            'apartment.seo_keywords',
        ];
    }

    public function slugs(): array
    {
        return [
            'apartment' => [
                ['name' => 'alias']
            ],
        ];
    }

    public function mount(Apartment $apartment)
    {
        if (!$apartment->exists) {
            $apartment->status = 1;
            $apartment->is_top = 0;
            $apartment->is_reference = 0;
            $apartment->category_id = request('category_id');
        }
        $this->apartment = $apartment;
        $this->categoryOptions = ApartmentCategory::asTextTree();
        $this->heatingOptions = Apartment::getHeatingOptions();
    }

    public function store()
    {
        $this->validate();
        if ($this->apartment->save()) {
            $this->saveMedia($this->apartment, 'floor_plan');
            $this->saveMedia($this->apartment, 'photos');
            $this->saveMedia($this->apartment, 'attachments');
            $alert = [
                'messageType' => 'success',
                'messageText' => __('All changes are saved.'),
            ];
            if (!$this->_stay) {
                return redirect($this->_return ?: route("admin.apartments.index"));
            }
        } else {
            $alert = [
                'messageType' => 'danger',
                'messageText' => __('An error occurred.'),
            ];
        }
        return redirect(route('admin.apartments.edit', ['apartment' => $this->apartment->id, '_return' => $this->_return]))
            ->with($alert);
    }
}
