<?php

namespace App\Traits;

trait LocalizedLinks
{
    public function getLinks(bool $absolute = false): array
    {
        $links = [];
        $languages = array_intersect($this->languages ?? [], supportedLocales()) ?: supportedLocales();
        foreach ($languages as $language) {
            $links[$language] = $this->getLink($language, $absolute);
        }
        return $links;
    }

    public function getTranslatedOrDefault($attribute, $locale = '')
    {
        return $locale ? $this->translate($attribute, $locale) : $this->$attribute;
    }
}
