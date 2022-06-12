<form action="{{ $action }}" method="post" enctype="multipart/form-data">
    @csrf
    @method($method)

    <x-admin.input
        required
        :attribute="'email'"
        :model="$model"
        :label="__('E-mail')" />

    <x-admin.select
        required
        :placeholder="''"
        :attribute="'role'"
        :model="$model"
        :options="$roles->pluck('name', 'name')"
        :label="__('Роль пользователя')" />

    <x-admin.input
        :required="!$model->exists"
        type="password"
        value=""
        :attribute="'password'"
        :model="$model"
        :label="__('Пароль')" />

    <x-admin.input
        required
        :attribute="'name'"
        :model="$model"
        :label="__('ФИО')" />

    <x-admin.select
        :attribute="'status'"
        :model="$model"
        :options="$statusOptions"
        :label="__('Статус')" />

    <x-admin.file
        :model="$model"
        :attribute="'photo'"
        :label="__('Фото')" />

    <div class="form-group">
        <button type="submit" name="save" class="btn btn-primary">{{ __('Сохранить') }}</button>
        <button type="submit" name="save_and_return" class="btn btn-success">{{ __('Сохранить и вернуться') }}</button>
        @if ($return_url)
            <a href="{{ $return_url }}" class="btn btn-default">
                {{ __('Вернуться') }}
            </a>
        @endif
    </div>
</form>
