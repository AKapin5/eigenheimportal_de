<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\MenuRequest;
use App\Models\Menu;
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

class MenuController
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
        $statusOptions = Menu::getStatusOptions();
        $parent = $this->getParent();
        $return_url = request()->getRequestUri();
        return view('admin.menu.index', compact('statusOptions', 'parent', 'return_url'));
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function getParent(): ?Menu
    {
        $parent_id = request()->get('parent_id');
        $menu = Menu::find($parent_id);
        if ($parent_id && !$menu) {
            throw new InvalidArgumentException('Invalid parent_id');
        }
        return $menu;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function search(Request $request): JsonResponse
    {
        return datatables()->eloquent(Menu::query())
            ->filter(function (Builder $query) use ($request) {
                if ($request->filled('id')) {
                    $query->where('id', $request->get('id'));
                }
                if ($request->filled('title')) {
                    $query->where('title->' . app()->getLocale(), 'like',
                        '%' . $request->get('name') . '%');
                }
                if ($request->filled('status')) {
                    $query->where('status', $request->get('status'));
                }
                $query->where('parent_id', $request->get('parent_id'));
                $query->orderBy('sort');
            })
            ->editColumn('title', function (Menu $model) {
                return $model->title;
            })
            ->editColumn('url', function (Menu $model) {
                return $model->url;
            })
            ->editColumn('status', function (Menu $model) {
                return $model->statusText;
            })
            ->editColumn('children', function (Menu $model) {
                $indexRoute = route("admin.menus.index", ['parent_id' => $model->id]);
                return '<a href="' . $indexRoute . '">' . __('Sub-items (:count)', ['count' => $model->children()->count()]) . '</a>';
            })
            ->addColumn('action', function ($model) use ($request) {
                $editRoute = route("admin.menus.edit", ['menu' => $model->id, 'return_url' => $request->get('return_url')]);
                $deleteRoute = route("admin.menus.destroy", ['menu' => $model->id, 'return_url' => $request->get('return_url')]);
                return view('admin.partials._actions', compact('model', 'editRoute', 'deleteRoute'));
            })
            ->rawColumns(['children', 'action'])
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
        $model = new Menu([
            'status' => 1,
            'parent_id' => request()->get('parent_id'),
        ]);
        $return_url = request()->get('return_url');
        return view("admin.menu.create", compact('model', 'return_url'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MenuRequest $request
     * @return RedirectResponse
     */
    public function store(MenuRequest $request): RedirectResponse
    {
        $model = new Menu(['parent_id' => $request->get('parent_id')]);
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
        return view("admin.menu.edit", compact('model', 'return_url'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param MenuRequest $request
     * @param int $id
     * @return RedirectResponse
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function update(MenuRequest $request, int $id): RedirectResponse
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
        return redirect($return_url ?: route("admin.menus.index"));
    }

    /**
     * @param $id
     * @return Menu|Model
     */
    protected function findModel($id): Menu
    {
        return Menu::query()->findOrFail($id);
    }

    /**
     * @param Menu $model
     * @param MenuRequest $request
     * @param string|null $return_url
     * @return RedirectResponse
     */
    protected function save(Menu $model, MenuRequest $request, ?string $return_url): RedirectResponse
    {
        $model->fill($request->get(shorten($model)));
        if (!isset($model->sort)) {
            $model->assignNewSort();
        }
        if ($model->save()) {
            session()->flash('message', __('All changes are saved.'));
            session()->flash('type', 'success');
            if (array_key_exists('save', $request->post())) {
                return redirect($return_url ?: route("admin.menus.index"));
            }
        } else {
            session()->flash('message', __('An error occurred.'));
            session()->flash('type', 'danger');
        }
        return redirect(route("admin.menus.edit", ['menu' => $model->id, 'return_url' => $return_url]));
    }
}
