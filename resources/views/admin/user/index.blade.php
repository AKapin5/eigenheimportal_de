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
                url: '{{ route('admin.users.search') }}',
                    data: function (d) {
                    d.id = $('input[name=id]').val();
                    d.email = $('input[name=email]').val();
                    d.name = $('input[name=name]').val();
                    d.status = $('select[name=status]').val();
                    d.return_url = '{{ $return_url }}';
                }
                },
                serverSide: true,
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'email', name: 'email' },
                    { data: 'role', name: 'role' },
                    { data: 'name', name: 'name' },
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
{{__('Пользователи')}}
@endsection

@section('content')

<div class="panel panel-default form-group">
        <div class="panel-body">
            <form method="POST" id="search-form" class="form" role="form" autocomplete="off">
                <div class="row">

                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="email">{{ __('Email') }}</label>
                            <input type="text" class="form-control" name="email" id="email" placeholder="{{ __('Email') }}">
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="name">{{ __('ФИО') }}</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="{{ __('ФИО') }}">
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="status">{{ __('Статус пользователя') }}</label>
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
                <a class="btn btn-success" href="{{ route('admin.users.create', ['return_url' => $return_url])}}">
                    {{ __('Создать') }}
                </a>
            </form>
        </div>
    </div>
    <table id="data_grid" class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>{{ __('ID') }}</th>
            <th>{{ __('Email') }}</th>
            <th>{{ __('Роль') }}</th>
            <th>{{ __('ФИО') }}</th>
            <th>{{ __('Статус') }}</th>
            <th></th>
        </tr>
        </thead>
    </table>
@endsection
