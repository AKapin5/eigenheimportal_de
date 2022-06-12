<?php

namespace App\Helpers;

use File;
use Image;
use Storage;

class ImageResizer
{
    public function thumb($path, $method, ...$args): string
    {
        $img = Image::make($path);
        $baseDir = pathinfo($path, PATHINFO_DIRNAME) . '/thumbs';
        if (!File::isDirectory($baseDir)) {
            File::makeDirectory($baseDir);
        }
        $thumb =  $baseDir . '/'
            . pathinfo($path, PATHINFO_FILENAME)
            . "_{$method}_" . implode('_', $args)
            . '.' . pathinfo($path, PATHINFO_EXTENSION);

        if (!file_exists($thumb)) {
            if ($method == 'resize') {
                call_user_func_array([$img, $method], array_merge($args, [function ($const) {
                    $const->aspectRatio();
                }]));
            } else {
                call_user_func_array([$img, $method], $args);
            }
            $img->save($thumb);
        }
        return Storage::url(trim(str_replace(storage_path('app/public'), '', $thumb), '\/'));
    }
}
