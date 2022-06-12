@extends('admin.layouts.master')

@push('js')
    <script>
        (function($) {
            let oTable = $('#data_grid').DataTable({
                "dom": 'ltipr',
                language: {
                    url: '{{ url('/admin-panel/libs/dataTables/language/Russian.json') }}'
                },
                ajax: {
                    url: '{{ url('/admin/pages/search') }}',
                    data: function (d) {
                        d.id = $('input[name=id]').val();
                        d.name = $('input[name=name]').val();
                        d.status = $('select[name=status]').val();
                        d.return_url = '{{ $return_url }}';
                    }
                },
                serverSide: true,
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'alias', name: 'alias' },
                    { data: 'status', name: 'status' },
                    { data: 'created_at', name: 'created_at'},
                    { data: 'updated_at', name: 'updated_at'},
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [ 0, "asc" ]
                ]
            });

            $('#search-form').on('submit', function(e) {
                oTable.draw();
                e.preventDefault();
            });
        })(jQuery);
    </script>
@endpush

@section('content_header')
    {{__('Страницы')}}
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
                            <label for="name">{{ __('Название') }}</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="{{ __('Название') }}">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="status">{{ __('Статус') }}</label>
                            <select name="status" id="status" class="form-control">
                                <option value=""></option>
                                @foreach($statusOptions as $value => $text)
                                    <option value="{{ $value }}">{{ $text }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">{{ __('Поиск') }}</button>
                <a class="btn btn-success" href="{{ route('admin.pages.create', ['return_url' => $return_url])}}">
                    {{ __('Создать') }}
                </a>
            </form>
        </div>
    </div>
    <table id="data_grid" class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>{{ __('ID') }}</th>
            <th>{{ __('Название') }}</th>
            <th>{{ __('Алиас') }}</th>
            <th>{{ __('Статус') }}</th>
            <th>{{ __('Дата создания') }}</th>
            <th>{{ __('Дата обновления') }}</th>
            <th></th>
        </tr>
        </thead>
    </table>
@endsection
