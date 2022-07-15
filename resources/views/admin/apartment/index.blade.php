@extends('admin.layouts.master')

@push('js')
    <script>
        (function($) {
            let oTable = $('#apartments').DataTable({
                "dom": 'ltipr',
                ordering: false,
                ajax: {
                    url: '{{ url('/admin/apartments/search') }}',
                    data: function (d) {
                        d.id = $('input[name=id]').val();
                        d.name = $('input[name=name]').val();
                        d.alias = $('input[name=alias]').val();
                        d.status = $('select[name=status]').val();
                        d.category_id = $('select[name=category_id]').val() || {{ $category->id ?? 'null' }};
                        d.return_url = '{{ $return_url }}';
                    }
                },
                serverSide: true,
                columns: [
                    { data: 'photo', name: 'photo' },
                    { data: 'id', name: 'id' },
                    { data: 'category_id', name: 'category_id' },
                    { data: 'name', name: 'name' },
                    { data: 'alias', name: 'alias' },
                    { data: 'status', name: 'status' },
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
    {{ __('Apartments') }}
    @if ($category)
        {{ __('in ":name"', ['name' => $category->name]) }}
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
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="status">{{ __('Category') }}</label>
                            <select name="category_id" id="category_id" class="form-control select2">
                                <option value=""></option>
                                @foreach($categoryOptions as $value => $text)
                                    <option value="{{ $value }}">{{ $text }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">{{ __('Search') }}</button>
                <a class="btn btn-success" href="{{ route("admin.apartments.create", ['category_id' => $category->id ?? null, 'return_url' => $return_url]) }}">
                    {{ __('Create') }}
                </a>
            </form>
        </div>
    </div>
    <table id="apartments" class="table table-striped table-bordered">
        <thead>
        <tr>
            <th></th>
            <th>{{ __('ID') }}</th>
            <th>{{ __('Category') }}</th>
            <th>{{ __('Name') }}</th>
            <th>{{ __('Alias') }}</th>
            <th>{{ __('Show') }}</th>
            <th></th>
        </tr>
        </thead>
    </table>
@endsection

