@if(session()->has('error'))
    @include('partials/error', ['type' => 'danger', 'message' => session('error')])
@endif
@if(session()->has('ok'))
    @include('partials/error', ['type' => 'success', 'message' => session('ok')])
@endif
@if(isset($info))
    @include('partials/error', ['type' => 'info', 'message' => $info])
@endif