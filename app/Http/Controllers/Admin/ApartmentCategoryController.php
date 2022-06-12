<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ApartmentCategoryRequest;
use App\Models\ApartmentCategory;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use InvalidArgumentException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class ApartmentCategoryController
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
        $statusOptions = ApartmentCategory::getStatusOptions();
        $parent = $this->getParent();
        $return_url = request()->getRequestUri();
        return view('admin.apartment-category.index', compact('statusOptions', 'parent', 'return_url'));
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function getParent(): ?ApartmentCategory
    {
        $parent_id = request()->get('parent_id');
        $model = ApartmentCategory::find($parent_id);
        if ($parent_id && !$model) {
            throw new InvalidArgumentException('Invalid parent_id');
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
        return datatables()->eloquent(ApartmentCategory::query())
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
                $query->where('parent_id', $request->get('parent_id'));
                $query->orderBy('sort');
            })
            ->editColumn('name', function (ApartmentCategory $model) {
                return $model->name;
            })
            ->editColumn('alias', function (ApartmentCategory $model) {
                return $model->alias;
            })
            ->editColumn('status', function (ApartmentCategory $model) {
                return $model->statusText;
            })
            ->editColumn('children', function (ApartmentCategory $model) {
                $indexRoute = route("admin.apartment-categories.index", ['parent_id' => $model->id]);
                return '<a href="' . $indexRoute . '">' . __('Sub-categories (:count)', ['count' => $model->children()->count()]) . '</a>';
            })
            ->editColumn('items', function (ApartmentCategory $model) {
                $indexRoute = route("admin.apartment-items.index", ['parent_id' => $model->id]);
                return '<a href="' . $indexRoute . '">' . __('Apartments (:count)', ['count' => $model->children()->count()]) . '</a>';
            })
            ->addColumn('action', function ($model) use ($request) {
                $editRoute = route("admin.apartment-categories.edit", ['apartment_category' => $model->id, 'return_url' => $request->get('return_url')]);
                $deleteRoute = route("admin.apartment-categories.destroy", ['apartment_category' => $model->id, 'return_url' => $request->get('return_url')]);
                return view('admin.partials._actions', compact('model', 'editRoute', 'deleteRoute'));
            })
            ->rawColumns(['children', 'items', 'action'])
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
        $model = new ApartmentCategory([
            'status' => 1,
            'parent_id' => request()->get('parent_id'),
        ]);
        $return_url = request()->get('return_url');
        $categoryOptions = $model->asTextTree(null, $model->id);
        return view("admin.apartment-category.create", compact('model', 'return_url', 'categoryOptions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ApartmentCategoryRequest $request
     * @return RedirectResponse
     */
    public function store(ApartmentCategoryRequest $request): RedirectResponse
    {
        $model = new ApartmentCategory(['parent_id' => $request->get('parent_id')]);
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
        $categoryOptions = $model->asTextTree(null, $model->id);
        return view("admin.apartment-category.edit", compact('model', 'return_url', 'categoryOptions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ApartmentCategoryRequest $request
     * @param int $id
     * @return RedirectResponse
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function update(ApartmentCategoryRequest $request, int $id): RedirectResponse
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
        return redirect($return_url ?: route("admin.apartment-categories.index"));
    }

    /**
     * @param $id
     * @return ApartmentCategory|Model
     */
    protected function findModel($id): ApartmentCategory
    {
        return ApartmentCategory::query()->findOrFail($id);
    }

    /**
     * @param ApartmentCategory $model
     * @param ApartmentCategoryRequest $request
     * @param string|null $return_url
     * @return RedirectResponse
     */
    protected function save(ApartmentCategory $model, ApartmentCategoryRequest $request, ?string $return_url): RedirectResponse
    {
        $model->fill($request->get(shorten($model)));
        if (!isset($model->sort)) {
            $model->assignNewSort();
        }
        if ($model->save()) {
            $model->updatePath();
            session()->flash('message', __('All changes are saved.'));
            session()->flash('type', 'success');
            if (array_key_exists('save', $request->post())) {
                return redirect($return_url ?: route("admin.apartment-categories.index"));
            }
        } else {
            session()->flash('message', __('An error occurred.'));
            session()->flash('type', 'danger');
        }
        return redirect(route("admin.apartment-categories.edit", ['apartment_category' => $model->id, 'return_url' => $return_url]));
    }
}
