<div id="toolbar">
    <div class="toolbar__container fixed--t-r">

        <div class="toolbar__main">
            @include('templates.toolbar.toolbarMain')
        </div>

        <div class="toolbar__minor">

            {{-----------------------------------------------------------------------------
            | Toolbar Portal
            ------------------------------------------------------------------------------}}
            @if (Auth::guest())
                @include('templates.toolbar.toolbarPortal')
            @elseif (Auth::check())
                @include('templates.toolbar.toolbarMinor')
            @endif
        </div>

    </div>
</div>
