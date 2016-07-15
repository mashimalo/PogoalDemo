@if(isset($errors) && count($errors->all())>0)
    <ul class="uiAlerts">
        @foreach(array_reverse($errors->all()) as $error)
            <li>
                @include('partials/error', ['type' => 'danger', 'message' => $error])
            </li>
        @endforeach
    </ul>
@endif