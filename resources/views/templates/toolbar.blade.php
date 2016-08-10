<div id="toolbar">
    <div class="toolbar__container fixed--t-r">
        <div class="site_container">
            <div class="toolbar__center overflow-h text-center">
                <h1>
                    <a href="{{ url('/') }}">
                        <img id="brand" src="{{ url('/assets/images/logo_3.png') }}" alt="Pogoal"/>
                        <span class="hidden-text">{{ trans('front/brand.pogoal') }}</span>
                    </a>
                </h1>
            </div>

            <div class="toolbar__main">
                @include('templates.toolbar.toolbarMain')
            </div>

            <div class="toolbar__minor">
                @if (Auth::guest())
                    @include('templates.toolbar.toolbarPortal')
                @elseif (Auth::check())
                    @include('templates.toolbar.toolbarMinor')
                @endif
            </div>

            {{----------------------------
            | Toolbar Search
            ----------------------------}}
            <div id="toolbar-search" class="toolbar__search">
                {!! Form::open(['route'=> ['searchGroup-get'], 'method'=>'GET','id'=>'search-group-form', 'role'=>'search'])!!}
                <div class="pull-right">
                    <div class="btn" data-action="toggle" data-target="#toolbar-search">
                        <span class="icon icon-cross text-lg"></span>
                    </div>
                    <button type="submit" class="btn">
                        <span class="icon icon-search text-lg"></span>
                    </button>
                </div>
                <div class="overflow-h">
                    <input type="text" name="searchGroups" class="form-control" placeholder="{{ trans('front/search.placeholder') }}">
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
