@extends('admin.layouts.master')

@push('js')
    <script>
        (function($) {
            let oTable = $('#menus').DataTable({
                "dom": 'ltipr',
                ordering: false,
                ajax: {
                    url: '{{ url('/admin/apartment-categories/search') }}',
                    data: function (d) {
                        d.id = $('input[name=id]').val();
                        d.name = $('input[name=name]').val();
                        d.alias = $('input[name=alias]').val();
                        d.status = $('select[name=status]').val();
                        d.parent_id = {{ $parent->id ?? 'null' }};
                        d.return_url = '{{ $return_url }}';
                    }
                },
                serverSide: true,
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'alias', name: 'alias' },
                    { data: 'status', name: 'status' },
                    {
                        data: 'children',
                        name: 'children',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'items',
                        name: 'items',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
            });

            $('#search-form').on('submit', function(e) {
                oTable.draw();
                e.preventDefault();
            });
        })(jQuery);
    </script>
@endpush

@section('content_header')
    {{ __('Apartment categories') }}
    @if ($parent)
        {{ __(' - ":name"', ['name' => $parent->name]) }}
    @endif
@endsection

@section('content')
    <div class="panel panel-default form-group">
        <div class="panel-body">
            <form method="POST" id="search-form" class="form" role="form" autocomplete="off">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="id">{{ __('ID') }}</label>
                            <input type="text" class="form-control" name="id" id="id" placeholder="{{ __('ID') }}">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="title">{{ __('Name') }}</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="{{ __('Name') }}">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="status">{{ __('Show') }}</label>
                            <select name="status" id="status" class="form-control">
                                <option value=""></option>
                                @foreach($statusOptions as $value => $text)
                                    <option value="{{ $value }}">{{ $text }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">{{ __('Search') }}</button>
                <a class="btn btn-success" href="{{ route("admin.apartment-categories.create", ['parent_id' => $parent->id ?? null, 'return_url' => $return_url]) }}">
                    {{ __('Create') }}
                </a>
            </form>
        </div>
    </div>
    <table id="menus" class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>{{ __('ID') }}</th>
            <th>{{ __('Name') }}</th>
            <th>{{ __('Alias') }}</th>
            <th>{{ __('Show') }}</th>
            <th>{{ __('Sub-categories') }}</th>
            <th>{{ __('Apartments') }}</th>
            <th></th>
        </tr>
        </thead>
    </table>
@endsection

