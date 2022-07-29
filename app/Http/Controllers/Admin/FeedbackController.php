<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Str;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $return_url = request()->getRequestUri();
        return view('admin.feedback.index',
            compact('return_url'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function search(Request $request): JsonResponse
    {
        return datatables()->eloquent(Feedback::query())
            ->filter(function (Builder $query) use ($request) {
                if ($request->filled('id')) {
                    $query->where('id', $request->get('id'));
                }
                if ($request->filled('name')) {
                    $query->where('name', 'like',
                        '%' . $request->get('name') . '%');
                }
                if ($request->filled('email')) {
                    $query->where('email', 'like',
                        '%' . $request->get('email') . '%');
                }
                if ($request->filled('text')) {
                    $query->where('text', 'like',
                        '%' . $request->get('text') . '%');
                }
                $query->orderBy('id', 'desc');
            })
            ->editColumn('name', function (Feedback $model) {
                return $model->name;
            })
            ->editColumn('email', function (Feedback $model) {
                return $model->email;
            })
            ->editColumn('text', function (Feedback $model) {
                return $model->text;
            })
            ->editColumn('created_at', function (Feedback $model) {
                return $model->created_at->format('d.m.Y H:i');
            })
            ->addColumn('action', function ($model) use ($request) {
                $deleteRoute = route("admin.feedback.destroy", ['feedback' => $model->id, 'return_url' => $request->get('return_url')]);
                return view('admin.partials._actions', compact('model', 'deleteRoute'));
            })
            ->rawColumns(['action'])
            ->make();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function destroy(int $id): RedirectResponse
    {
        $model = $this->findModel($id);
        $model->delete();
        $return_url = request()->get('return_url');
        return redirect($return_url ?: route("admin.blogs.index"));
    }

    /**
     * @param $id
     * @return Feedback|Model
     */
    protected function findModel($id): Model|Feedback
    {
        return Feedback::query()->findOrFail($id);
    }
}
