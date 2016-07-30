{{----------------------------
| LOGO
----------------------------}}
<h1><a href="{{ url('/') }}"><span id="brand" class="icon icon-logo-temp"></span><span class="hidden-text">{{ trans('front/brand.pogoal') }}</span></a></h1>

{{----------------------------
| Toolbar Search
----------------------------}}
<div id="toolbar__search" class="toolbar__search">
    {!! Form::open(['route'=> ['searchGroup-get'], 'method'=>'GET','id'=>'search-group-form', 'role'=>'search'])!!}
    <div class="input-group">
        <input type="text" name="searchGroups" class="form-control" placeholder="{{ trans('front/search.placeholder') }}">
        <div class="input-group-btn">
            <button class="btn" type="submit">
                <span class="icon icon-search"></span>
            </button>
        </div>
    </div>
    {!! Form::close() !!}
</div>