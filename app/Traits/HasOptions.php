<?php


namespace App\Traits;


use Str;

/**
 * Trait OptionsField
 * @package App\Traits
 */
trait HasOptions
{
    /**
     * @param $name
     * @return mixed|string
     */
    public function __get($name)
    {
        foreach ($this->optionsFields as $field) {
            $camelCase = Str::camel($field);
            if ($name == $camelCase . 'Text') {
                $options = $this->{"get" . ucfirst($camelCase) . 'Options'}();
                return $options[$this->$field] ?? '';
            }
        }
        return $this->getAttribute($name);
    }
}
