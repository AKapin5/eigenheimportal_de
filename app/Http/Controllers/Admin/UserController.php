<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\User;
use Exception;
use Hash;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Spatie\Permission\Models\Role;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $statusOptions = User::getStatusOptions();
        $return_url = request()->getRequestUri();
        return view('admin.user.index', compact('statusOptions', 'return_url'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function search(Request $request): JsonResponse
    {
        return datatables()->eloquent(User::query())
            ->filter(function (Builder $query) use ($request) {
                if ($request->filled('id')) {
                    $query->where('id', $request->get('id'));
                }
                if ($request->filled('email')) {
                    $query->where('email', 'like', '%' . $request->get('email') . '%');
                }

                if ($request->filled('name')) {
                    $query->where('name', 'like', '%' . $request->get('name') . '%');
                }

                if ($request->filled('status')) {
                    $query->where('status', $request->get('status'));
                }
                if (!$request->user()->hasRole('admin')) {
                    $query->whereHas('roles', function(Builder $query) {
                        $query->where('name', '!=', 'admin');
                    });
                }
            })
            ->editColumn('status', function (User $model) {
                return $model->getStatusText();
            })
            ->editColumn('role', function (User $model) {
                return $model->role;
            })
            ->addColumn('action', function (User $model) use ($request) {
                $editRoute = route('admin.users.edit', ['user' => $model->id, 'return_url' => $request->get('return_url')]);
                $deleteRoute = route('admin.users.destroy', ['user' => $model->id, 'return_url' => $request->get('return_url')]);
                return view('admin.partials._actions', compact('model', 'editRoute', 'deleteRoute'));
            })
            ->escapeColumns(['name'])
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
        $model = new User([
            'status' => 1,
        ]);

        $statusOptions = User::getStatusOptions();
        $roles = $this->getRoles();
        $return_url = request()->get('return_url');
        return view('admin.user.create', compact('model', 'statusOptions', 'roles', 'return_url'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return RedirectResponse
     */
    public function store(UserRequest $request): RedirectResponse
    {
        $model = new User();
        $return_url = $request->get('return_url');
        return $this->save($model, $request, $return_url);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @throws Exception
     */
    public function show(int $id)
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
        if (!$this->getIdentity()->hasRole('admin') && $model->hasRole('admin')) {
            abort(403);
        }
        $statusOptions = User::getStatusOptions();
        $roles = $this->getRoles();
        $return_url = request()->get('return_url');
        return view('admin.user.edit', compact('model', 'statusOptions', 'roles', 'return_url'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param int $id
     * @return RedirectResponse
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function update(UserRequest $request, int $id): RedirectResponse
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
        return redirect($return_url ?: route('admin.users.index'));
    }

    /**
     * @param $id
     * @return User|Model
     */
    protected function findModel($id) : ?User
    {
        return User::query()->findOrFail($id);
    }

    /**
     * @param User $model
     * @param UserRequest $request
     * @param string|null $return_url
     * @return RedirectResponse
     */
    protected function save(User $model, UserRequest $request, ?string $return_url): RedirectResponse
    {
        $currentPassword = $model->password;
        $model->fill($request->get(shorten($model)));

        if ($request->filled('password')) {
            $model->password = Hash::make($request->get('password'));
        } else {
            $model->password = $currentPassword;
        }

        if (!$model->exists) {
            $model->generateToken();
        }
        if ($model->save()) {
            $model->uploadAllMediaFromRequest();
            session()->flash('message', __('All changes are saved.'));
            session()->flash('type', 'success');

            if (array_key_exists('save', $request->post())) {
                return redirect($return_url ?: route('admin.users.index'));
            }
        } else {
            session()->flash('message', __('An error occurred.'));
            session()->flash('type', 'danger');
        }
        return redirect(route('admin.users.edit', ['user' => $model->id, 'return_url' => $return_url]));
    }

    /**
     * @return Collection
     */
    protected function getRoles(): Collection
    {
        $query = Role::query();
        if (!$this->getIdentity()->hasRole('admin')) {
            $query->where('name', '!=', 'admin');
        }
        return $query->get();
    }

    /**
     * @return Authenticatable|User|null
     */
    protected function getIdentity(): User|Authenticatable|null
    {
        return auth()->user();
    }
}
