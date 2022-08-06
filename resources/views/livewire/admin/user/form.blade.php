<x-slot:title>
    @if ($user->exists)
        {{ __('Edit user ":name"', ['name' => $user->name]) }}
    @else
        {{ __('Create user') }}
    @endif
</x-slot>
<form wire:submit.prevent="store()" method="post" enctype="multipart/form-data">
    @if($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <x-admin.form.input
        :attribute="'user.name'"
        :model="$user"
        :label="__('Name')" />

    <x-admin.form.input
        :attribute="'user.email'"
        :model="$user"
        :label="__('Email')" />

    <x-admin.form.input
        type="password"
        :attribute="'password_clean'"
        :model="$user"
        :label="__('Password')" />

    <x-admin.form.select
        multiple
        data-allow-clear="true"
        :type="'select2'"
        :attribute="'roles'"
        :options="$roleOptions"
        :model="$user"
        :label="__('Roles')" />

    <x-admin.form.select
        :type="'select2'"
        :attribute="'user.status'"
        :options="$statusOptions"
        :model="$user"
        :label="__('Status')" />

    <div class="mb-3">
        <button type="submit" wire:click="$set('_stay', false)" class="btn btn-success">
            {{ __('Save') }}
        </button>
        <button type="submit" class="btn btn-primary" wire:click="$set('_stay', true)">
            {{ __('Save and return') }}
        </button>
        @if ($_return)
            <a href="{{ $_return }}" class="btn btn-secondary">{{ __('← Back') }}</a>
        @endif
    </div>
</form>
