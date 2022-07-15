<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ApartmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'apartment.name.' . app()->getLocale() => ['required'],
            'apartment.name.*' => 'max:255',
            'apartment.alias.' . app()->getLocale() => ['required'],
            'apartment.alias.*' => 'max:255',
            'apartment.category_id' => 'integer|nullable|required',
            'apartment.status' => 'integer',
            'apartment.is_top' => 'integer',
            'apartment.description.*' => 'max:50000',
            'apartment.seo_title.*' => 'max:255',
            'apartment.seo_keywords.*' => 'max:50000',
            'apartment.seo_description.*' => 'max:50000',
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
            'apartment.location_map' => 'max:255|nullable',
            'apartment.location_address' => 'nullable',
            'apartment.photos.*' => 'image',
        ];
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        return [
            'apartment.name.*' => __('Name'),
            'apartment.alias.*' => __('Alias'),
            'apartment.description.*' => __('Description'),
            'apartment.seo_title.*' => __('Seo title'),
            'apartment.seo_keywords.*' => __('Seo keywords'),
            'apartment.seo_description.*' => __('Seo description'),
            'apartment.category_id' => __('Category'),
            'apartment.status' => __('Show'),
            'apartment.is_top' => __('Is top'),
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
            'apartment.photos' => __('Photos'),
        ];
    }
}

