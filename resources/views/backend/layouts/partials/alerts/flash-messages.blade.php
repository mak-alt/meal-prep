@empty($key)
    @if(session()->has('success'))
        <div class="alert alert-success">
            <strong><i class="fa fa-check-circle"></i> {{ session()->get('success') }}</strong>
        </div>
    @endif

    @if(session()->has('error'))
        <div class="alert alert-danger">
            <strong><i class="fa fa-exclamation-circle"></i> {{ session()->get('error') }}</strong>
        </div>
    @endif

    @if(session()->has('warning'))
        <div class="alert alert-warning">
            <strong><i class="fa fa-exclamation-triangle"></i> {{ session()->get('warning') }}</strong>
        </div>
    @endif
@else
    @if(session()->has($key))
        <div class="alert {{ !empty($alertClass) ? $alertClass : '' }}">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>
                @if(!empty($alertClass))
                    @switch($alertClass)
                        @case('alert-success')
                        <i class="fa fa-check-circle"></i>
                        @break
                        @case('alert-error')
                        <i class="fa fa-exclamation-circle"></i>
                        @break
                        @case('alert-warning')
                        <i class="fa fa-exclamation-triangle"></i>
                        @break
                    @endswitch
                @endif
                {{ session()->get($key) }}
            </strong>
        </div>
    @endif
@endempty
