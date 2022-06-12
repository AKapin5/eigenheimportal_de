<div class="btn-toolbar btn-actions">
    @isset ($editRoute)
        <a class="btn btn-xs btn-primary mb-1" href="{{ $editRoute }}">
            <i class="fa fa-edit"></i> {{ __('Edit') }}
        </a>
    @endif

    @isset ($deleteRoute)
        <form class="my-0" method="post" action="{{ $deleteRoute }}"
              onsubmit="return confirm('{{ __('Are you sure to delete this record?')  }}')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-xs btn-danger">
                <i class="fa fa-trash"></i> {{ __('Delete') }}
            </button>
        </form>
    @endif
</div>
