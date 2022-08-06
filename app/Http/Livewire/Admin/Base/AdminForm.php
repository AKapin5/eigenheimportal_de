<?php

namespace App\Http\Livewire\Admin\Base;

use Str;

class AdminForm extends BaseComponent
{
    public $_stay;

    public $_return;

    public function booted()
    {
        if (!$this->_return) {
            $this->_return = request('_return');
        }
    }

    public function hydrate()
    {
        $this->emit('hydrate');
    }

    public function getMultilingual()
    {
        return method_exists($this, 'multilingual') ? $this->multilingual() : [];
    }

    public function getRules()
    {
        return $this->transform(parent::getRules());
    }

    public function getValidationAttributes()
    {
        return $this->transform(parent::getValidationAttributes());
    }

    protected function transform(array $entries): array
    {
        $multilingual = $this->getMultilingual();
        $result = [];
        foreach ($entries as $key => $entry) {
            if (in_array($key, $multilingual)) {
                foreach (supportedLocales() as $locale) {
                    $result["$key.$locale"] = $entry;
                }
            } else {
                $result[$key] = $entry;
            }
        }
        return $result;
    }

    public function updated($field, $value)
    {
        if (method_exists($this, 'slugs')) {
            $this->generateSlugs($field, $value);
        }
    }


    public function generateSlugs($field, $value)
    {
        foreach ($this->slugs() as $modelKey => $slugs) {
            foreach ($slugs as $slug) {
                $source = key($slug);
                $target = end($slug);
                foreach (supportedLocales() as $locale) {
                    if ($field == "$modelKey.$source.$locale" && !$this->$modelKey->exists) {
                        $this->$modelKey->setTranslation($target, $locale, Str::slug($value));
                    }
                }
            }
        }
    }

    protected function saveMedia($model, $attribute)
    {
        if (is_array($this->$attribute)) {
            foreach ($this->$attribute as $file) {
                $model->addMedia($file)->toMediaCollection($attribute);
            }
        } else {
            if ($this->$attribute) {
                $model->clearMediaCollection($attribute);
                $model->addMedia($this->$attribute)->toMediaCollection($attribute);
            }
        }
    }
}
