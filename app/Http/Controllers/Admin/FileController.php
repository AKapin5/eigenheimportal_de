<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class FileController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function remove(Request $request): JsonResponse
    {
        $uuid = $request->get('uuid');
        $media = Media::findByUuid($uuid);
        if (!$media) {
            abort('404');
        }
        return response()->json([
            'success' => $media->delete(),
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function sort(Request $request): JsonResponse
    {
        $ids = $request->get('ids');
        Media::setNewOrder($ids);
        return response()->json([
            'success' => true,
        ]);
    }
}
