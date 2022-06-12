<?php

namespace App\Helpers;

use Str;

class UrlFormatter
{
    /**
     * @param $url
     * @param null $locale
     * @param false $absolute
     * @return string
     */
    public static function localizeUrl($url, $locale = null, bool $absolute = false): string
    {
        if (empty($locale)) {
            $locale = app()->getLocale();
        }
        if (Str::contains($url, '://')) {
            return $url;
        }
        $defaultLocale = config('localized-routes.omit_url_prefix_for_locale');
        if ($locale != $defaultLocale) {
            $url = '/' . $locale . '/' . ltrim($url, '/');
        }
        $hasTrailingSlash = Str::endsWith($url, '/');
        return rtrim($absolute ? url()->to($url) : $url, '/') . ($hasTrailingSlash ? '/' : '');
    }
}
