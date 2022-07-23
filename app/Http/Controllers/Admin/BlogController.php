<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlogRequest;
use App\Models\Blog;
use App\Models\BlogCategory;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use InvalidArgumentException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;


class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index(): View
    {
        $statusOptions = Blog::getStatusOptions();
        $categoryOptions = BlogCategory::pluck('name', 'id');
        $category = $this->getCategory();
        $return_url = request()->getRequestUri();
        return view('admin.blog.index',
            compact('statusOptions', 'categoryOptions', 'category', 'return_url'));
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function getCategory(): ?BlogCategory
    {
        $category_id = request()->get('category_id');
        $model = BlogCategory::find($category_id);
        if ($category_id && !$model) {
            throw new InvalidArgumentException('Invalid category_id');
        }
        return $model;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function search(Request $request): JsonResponse
    {
        return datatables()->eloquent(Blog::query())
            ->filter(function (Builder $query) use ($request) {
                if ($request->filled('id')) {
                    $query->where('id', $request->get('id'));
                }
                if ($request->filled('name')) {
                    $query->where('name->' . app()->getLocale(), 'like',
                        '%' . $request->get('name') . '%');
                }
                if ($request->filled('status')) {
                    $query->where('status', $request->get('status'));
                }
                if ($request->filled('category_id')) {
                    $query->where('category_id', $request->get('category_id'));
                }
            })
            ->editColumn('photo', function (Blog $model) {
                if ($file = $model->getFirstMedia('photo')) {
                    return '<img src="' . thumb($file, 'fit', 100) . '">';
                } else {
                    return null;
                }
            })
            ->editColumn('category_id', function (Blog $model) {
                return $model->category->name;
            })
            ->editColumn('name', function (Blog $model) {
                return $model->name;
            })
            ->editColumn('alias', function (Blog $model) {
                return $model->alias;
            })
            ->editColumn('status', function (Blog $model) {
                return $model->statusText;
            })
            ->addColumn('action', function ($model) use ($request) {
                $editRoute = route("admin.blogs.edit", ['blog' => $model->id, 'return_url' => $request->get('return_url')]);
                $deleteRoute = route("admin.blogs.destroy", ['blog' => $model->id, 'return_url' => $request->get('return_url')]);
                return view('admin.partials._actions', compact('model', 'editRoute', 'deleteRoute'));
            })
            ->rawColumns(['action', 'photo'])
            ->make();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function create(): View
    {
        $model = new Blog([
            'status' => 1,
            'category_id' => request()->get('category_id'),
        ]);
        $return_url = request()->get('return_url');
        $categoryOptions = BlogCategory::pluck('name', 'id');
        return view("admin.blog.create",
            compact('model', 'return_url', 'categoryOptions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BlogRequest $request
     * @return RedirectResponse
     */
    public function store(BlogRequest $request): RedirectResponse
    {
        $model = new Blog(['category_id' => $request->get('category_id')]);
        $return_url = $request->get('return_url');
        return $this->save($model, $request, $return_url);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return View
     * @throws Exception
     */
    public function show(int $id): View
    {
        throw new Exception('Not implemented');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return View
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function edit(int $id): View
    {
        $model = $this->findModel($id);
        $return_url = request()->get('return_url');
        $categoryOptions = BlogCategory::pluck('name', 'id');
        return view("admin.blog.edit",
            compact('model', 'return_url', 'categoryOptions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BlogRequest $request
     * @param int $id
     * @return RedirectResponse
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function update(BlogRequest $request, int $id): RedirectResponse
    {
        $model = $this->findModel($id);
        $return_url = request()->get('return_url');
        return $this->save($model, $request, $return_url);
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
     * @return Blog|Model
     */
    protected function findModel($id): Model|Blog
    {
        return Blog::query()->findOrFail($id);
    }

    /**
     * @param Blog $model
     * @param BlogRequest $request
     * @param string|null $return_url
     * @return RedirectResponse
     */
    protected function save(Blog $model, BlogRequest $request, ?string $return_url): RedirectResponse
    {
        $model->fill($request->get(shorten($model)));
        if ($model->save()) {
            $model->uploadAllMediaFromRequest();
            session()->flash('message', __('All changes are saved.'));
            session()->flash('type', 'success');
            if (array_key_exists('save', $request->post())) {
                return redirect($return_url ?: route("admin.blogs.index"));
            }
        } else {
            session()->flash('message', __('An error occurred.'));
            session()->flash('type', 'danger');
        }
        return redirect(route("admin.blogs.edit", ['blog' => $model->id, 'return_url' => $return_url]));
    }
}
