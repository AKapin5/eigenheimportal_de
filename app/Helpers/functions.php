<?php

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

if (! function_exists('shorten')) {
    function shorten($model): string {
        return lcfirst(class_basename($model));
    }
}

if (! function_exists('dot2Brackets')) {
    function dot2Brackets($string): string {
        return implode('', collect(explode('.', $string))->map(fn($e) => "[$e]")->all());
    }
}

if (! function_exists('dot2Hyphen')) {
    function dot2Hyphen($string): string {
        return implode('-', collect(explode('.', $string))->map(fn($e) => strtolower($e))->all());
    }
}

if (! function_exists('formatBytes')) {
    function formatBytes($size): string {
        return App\Helpers\HumanReadable::bytes($size);
    }
}

if (! function_exists('supportedLocales')) {
    function supportedLocales(): array {
        return config('localized-routes.supported-locales');
    }
}

if (! function_exists('thumb')) {
    function thumb($file, $method, ...$args): string {
        if (!in_array($file->mime_type, ['image/jpeg', 'image/gif', 'image/png'])) {
            return false;
        }
        return resolve(App\Helpers\ImageResizer::class)
            ->thumb($file->getPath(), $method, ...$args);
    }
}

if (! function_exists('paginate')) {
    function paginate(LengthAwarePaginator $paginator, $full = false, $class = null, $additionalLinks = false): string {
        return PaginateRoute::renderPageList($paginator, $full, $class, $additionalLinks);
    }
}

if (! function_exists('localizeUrl')) {
    function localizeUrl($url, $locale = null): string {
        return App\Helpers\UrlFormatter::localizeUrl($url, $locale);
    }
}
