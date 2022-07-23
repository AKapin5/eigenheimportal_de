<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlogCategoryRequest;
use App\Models\BlogCategory;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $statusOptions = BlogCategory::getStatusOptions();
        $return_url = request()->getRequestUri();
        return view('admin.blog-category.index', compact('statusOptions', 'return_url'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function search(Request $request): JsonResponse
    {
        return datatables()->eloquent(BlogCategory::query())
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
                $query->orderBy('sort');
            })
            ->editColumn('name', function (BlogCategory $model) {
                return $model->name;
            })
            ->editColumn('alias', function (BlogCategory $model) {
                return $model->alias;
            })
            ->editColumn('status', function (BlogCategory $model) {
                return $model->statusText;
            })
            ->editColumn('items', function (BlogCategory $model) {
                $indexRoute = route("admin.blogs.index", ['category_id' => $model->id]);
                return '<a href="' . $indexRoute . '">' . __('Blogs (:count)', ['count' => $model->blogs()->count()]) . '</a>';
            })
            ->addColumn('action', function ($model) use ($request) {
                $editRoute = route("admin.blog-categories.edit", ['blog_category' => $model->id, 'return_url' => $request->get('return_url')]);
                $deleteRoute = route("admin.blog-categories.destroy", ['blog_category' => $model->id, 'return_url' => $request->get('return_url')]);
                return view('admin.partials._actions', compact('model', 'editRoute', 'deleteRoute'));
            })
            ->rawColumns(['items', 'action'])
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
        $model = new BlogCategory([
            'status' => 1,
        ]);
        $return_url = request()->get('return_url');
        return view("admin.blog-category.create", compact('model', 'return_url'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BlogCategoryRequest $request
     * @return RedirectResponse
     */
    public function store(BlogCategoryRequest $request): RedirectResponse
    {
        $model = new BlogCategory();
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
        return view("admin.blog-category.edit", compact('model', 'return_url'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BlogCategoryRequest $request
     * @param int $id
     * @return RedirectResponse
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function update(BlogCategoryRequest $request, int $id): RedirectResponse
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
        return redirect($return_url ?: route("admin.blog-categories.index"));
    }

    /**
     * @param $id
     * @return BlogCategory|Model
     */
    protected function findModel($id): Model|BlogCategory
    {
        return BlogCategory::query()->findOrFail($id);
    }

    /**
     * @param BlogCategory $model
     * @param BlogCategoryRequest $request
     * @param string|null $return_url
     * @return RedirectResponse
     */
    protected function save(BlogCategory $model, BlogCategoryRequest $request, ?string $return_url): RedirectResponse
    {
        $model->fill($request->get(shorten($model)));
        if (!isset($model->sort)) {
            $model->assignNewSort();
        }
        if ($model->save()) {
            session()->flash('message', __('All changes are saved.'));
            session()->flash('type', 'success');
            if (array_key_exists('save', $request->post())) {
                return redirect($return_url ?: route("admin.blog-categories.index"));
            }
        } else {
            session()->flash('message', __('An error occurred.'));
            session()->flash('type', 'danger');
        }
        return redirect(route("admin.blog-categories.edit", ['blog_category' => $model->id, 'return_url' => $return_url]));
    }
}
