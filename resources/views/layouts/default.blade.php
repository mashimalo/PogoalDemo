{{----------------------------
| Head & Header
----------------------------}}
@include('templates.header')


{{----------------------------
| Layout
----------------------------}}
    <div id="content" class="page__content site-container">

        @yield('content')

    </div>


{{----------------------------
| Footer
----------------------------}}
@include('templates.footer')