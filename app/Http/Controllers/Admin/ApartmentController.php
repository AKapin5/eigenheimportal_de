<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ApartmentRequest;
use App\Models\Apartment;
use App\Models\ApartmentCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use InvalidArgumentException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Exception;


class ApartmentController
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
        $statusOptions = Apartment::getStatusOptions();
        $categoryOptions = ApartmentCategory::asTextTree();
        $category = $this->getCategory();
        $return_url = request()->getRequestUri();
        return view('admin.apartment.index',
            compact('statusOptions', 'categoryOptions', 'category', 'return_url'));
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function getCategory(): ?ApartmentCategory
    {
        $category_id = request()->get('category_id');
        $model = ApartmentCategory::find($category_id);
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
        return datatables()->eloquent(Apartment::query())
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
                    $category = $this->getCategory();
                    $query->ofCategory($category);
                }
            })
            ->editColumn('photo', function (Apartment $model) {
                if ($file = $model->getFirstMedia('photos')) {
                    return '<img src="' . thumb($file, 'fit', 100) . '">';
                } else {
                    return null;
                }
            })
            ->editColumn('category_id', function (Apartment $model) {
                return $model->category->name;
            })
            ->editColumn('price', function (Apartment $model) {
                return $model->price;
            })
            ->editColumn('name', function (Apartment $model) {
                return $model->name;
            })
            ->editColumn('alias', function (Apartment $model) {
                return $model->alias;
            })
            ->editColumn('is_top', function (Apartment $model) {
                return $model->isTopText;
            })
            ->editColumn('status', function (Apartment $model) {
                return $model->statusText;
            })
            ->addColumn('action', function ($model) use ($request) {
                $editRoute = route("admin.apartments.edit", ['apartment' => $model->id, 'return_url' => $request->get('return_url')]);
                $deleteRoute = route("admin.apartments.destroy", ['apartment' => $model->id, 'return_url' => $request->get('return_url')]);
                return view('admin.partials._actions', compact('model', 'editRoute', 'deleteRoute'));
            })
            ->rawColumns(['children', 'items', 'action', 'photo'])
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
        $model = new Apartment([
            'status' => 1,
            'price' => 0,
            'category_id' => request()->get('category_id'),
        ]);
        $return_url = request()->get('return_url');
        $categoryOptions = ApartmentCategory::asTextTree();
        $heatingOptions = Apartment::getHeatingOptions();
        return view("admin.apartment.create",
            compact('model', 'return_url', 'categoryOptions', 'heatingOptions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ApartmentRequest $request
     * @return RedirectResponse
     */
    public function store(ApartmentRequest $request): RedirectResponse
    {
        $model = new Apartment(['category_id' => $request->get('category_id')]);
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
        $categoryOptions = ApartmentCategory::asTextTree();
        $heatingOptions = Apartment::getHeatingOptions();
        return view("admin.apartment.edit",
            compact('model', 'return_url', 'categoryOptions', 'heatingOptions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ApartmentRequest $request
     * @param int $id
     * @return RedirectResponse
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function update(ApartmentRequest $request, int $id): RedirectResponse
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
        return redirect($return_url ?: route("admin.apartments.index"));
    }

    /**
     * @param $id
     * @return Apartment|Model
     */
    protected function findModel($id): Model|Apartment
    {
        return Apartment::query()->findOrFail($id);
    }

    /**
     * @param Apartment $model
     * @param ApartmentRequest $request
     * @param string|null $return_url
     * @return RedirectResponse
     */
    protected function save(Apartment $model, ApartmentRequest $request, ?string $return_url): RedirectResponse
    {
        $model->fill($request->get(shorten($model)));
        if ($model->save()) {
            $model->uploadAllMediaFromRequest($request->multipleUploadFileAttributes());
            session()->flash('message', __('All changes are saved.'));
            session()->flash('type', 'success');
            if (array_key_exists('save', $request->post())) {
                return redirect($return_url ?: route("admin.apartments.index"));
            }
        } else {
            session()->flash('message', __('An error occurred.'));
            session()->flash('type', 'danger');
        }
        return redirect(route("admin.apartments.edit", ['apartment' => $model->id, 'return_url' => $return_url]));
    }
}
