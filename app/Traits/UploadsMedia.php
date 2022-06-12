<?php

namespace App\Traits;

use Spatie\MediaLibrary\InteractsWithMedia;

trait UploadsMedia
{
    use InteractsWithMedia;

    /**
     * @param array $append
     */
    public function uploadAllMediaFromRequest(array $append = []): void
    {
        $request = request();
        $modelName = shorten($this);
        foreach (array_keys($request->files->get($modelName, [])) as $key) {
            if (!in_array($key, $append)) {
                $this->clearMediaCollection($key);
            }
            $this->addMultipleMediaFromRequest([$modelName . dot2Brackets($key)])->each(function ($fileAdder) use ($key) {
                $fileAdder->toMediaCollection($key);
            });
        }
    }
}
