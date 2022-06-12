<?php

namespace App\Traits;

trait HasTranslations
{
    use \Spatie\Translatable\HasTranslations;

    protected function asJson($value): string
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }
}
