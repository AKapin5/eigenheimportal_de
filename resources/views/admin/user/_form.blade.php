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
        :label="__('Role')" />

    <x-admin.input
        :required="!$model->exists"
        type="password"
        value=""
        :attribute="'password'"
        :model="$model"
        :label="__('Password')" />

    <x-admin.input
        required
        :attribute="'name'"
        :model="$model"
        :label="__('Name')" />

    <x-admin.select
        :attribute="'status'"
        :model="$model"
        :options="$statusOptions"
        :label="__('Status')" />

    <x-admin.file
        :model="$model"
        :attribute="'photo'"
        :label="__('Photo')" />

    <div class="form-group">
        <button type="submit" name="save" class="btn btn-primary">{{ __('Save') }}</button>
        <button type="submit" name="save_and_return" class="btn btn-success">{{ __('Save & return') }}</button>
        @if ($return_url)
            <a href="{{ $return_url }}" class="btn btn-default">
                {{ __('Back') }}
            </a>
        @endif
    </div>
</form>
