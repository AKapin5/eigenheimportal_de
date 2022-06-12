<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PageRequest;
use App\Models\Page;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;


class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $statusOptions = Page::getStatusOptions();
        $return_url = request()->getRequestUri();
        return view('admin.page.index', compact('statusOptions', 'return_url'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function search(Request $request): JsonResponse
    {
        return datatables()->eloquent(Page::query())
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
            })
            ->editColumn('name', function (Page $model) {
                return $model->name;
            })
            ->editColumn('alias', function (Page $model) {
                return $model->alias;
            })
            ->editColumn('created_at', function (Page $model) {
                return $model->created_at->format('d.m.Y H:i');
            })
            ->editColumn('updated_at', function (Page $model) {
                return $model->updated_at->format('d.m.Y H:i');
            })
            ->editColumn('status', function (Page $model) {
                return $model->statusText;
            })
            ->addColumn('action', function ($model) use ($request) {
                $editRoute = route('admin.pages.edit', ['page' => $model->id, 'return_url' => $request->get('return_url')]);
                $deleteRoute = route('admin.pages.destroy', ['page' => $model->id, 'return_url' => $request->get('return_url')]);
                return view('admin.partials._actions', compact('model', 'editRoute', 'deleteRoute'));
            })
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
        $model = new Page([
            'status' => 1
        ]);
        $return_url = request()->get('return_url');
        return view('admin.page.create', compact('model', 'return_url'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PageRequest $request
     * @return RedirectResponse
     */
    public function store(PageRequest $request): RedirectResponse
    {
        $model = new Page();
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
        return view('admin.page.edit', compact('model', 'return_url'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PageRequest $request
     * @param int $id
     * @return RedirectResponse
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function update(PageRequest $request, int $id): RedirectResponse
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
        return redirect($return_url ?: route('admin.pages.index'));
    }

    /**
     * @param $id
     * @return Page|Model
     */
    protected function findModel($id): ?Page
    {
        return Page::query()->findOrFail($id);
    }

    /**
     * @param Page $model
     * @param PageRequest $request
     * @param string|null $return_url
     * @return RedirectResponse
     */
    protected function save(Page $model, PageRequest $request, ?string $return_url): RedirectResponse
    {
        $model->fill($request->get(shorten($model)));
        if ($model->save()) {
            $model->uploadAllMediaFromRequest(['images']);
            session()->flash('message', __('Все изменения успешно сохранены.'));
            session()->flash('type', 'success');
            if (array_key_exists('save', $request->post())) {
                return redirect($return_url ?: route('admin.pages.index'));
            }
        } else {
            session()->flash('message', __('При сохранении возникла ошибка.'));
            session()->flash('type', 'danger');
        }
        return redirect(route('admin.pages.edit', ['page' => $model->id, 'return_url' => $return_url]));
    }
}
