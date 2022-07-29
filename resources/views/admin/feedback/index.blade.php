@extends('admin.layouts.master')

@push('js')
    <script>
        (function($) {
            let oTable = $('#feedback').DataTable({
                "dom": 'ltipr',
                ordering: false,
                ajax: {
                    url: '{{ url('/admin/feedback/search') }}',
                    data: function (d) {
                        d.id = $('input[name=id]').val();
                        d.name = $('input[name=name]').val();
                        d.email = $('input[name=email]').val();
                        d.text = $('select[name=text]').val();
                        d.return_url = '{{ $return_url }}';
                    }
                },
                serverSide: true,
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'text', name: 'text' },
                    { data: 'created_at', name: 'created_at' },
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
    {{ __('Feedback') }}
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
                            <label for="title">{{ __('Email') }}</label>
                            <input type="text" class="form-control" name="email" id="email" placeholder="{{ __('Email') }}">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="title">{{ __('Text') }}</label>
                            <input type="text" class="form-control" name="text" id="text" placeholder="{{ __('Text') }}">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">{{ __('Search') }}</button>
            </form>
        </div>
    </div>
    <table id="feedback" class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>{{ __('ID') }}</th>
            <th>{{ __('Name') }}</th>
            <th>{{ __('Email') }}</th>
            <th>{{ __('Text') }}</th>
            <th>{{ __('Date') }}</th>
            <th></th>
        </tr>
        </thead>
    </table>
@endsection

