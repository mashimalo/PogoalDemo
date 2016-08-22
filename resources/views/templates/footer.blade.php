    </div> {{-- #page / .page --}}

    <footer id="footer" class="site__footer">
        <div class="footer__info site-container">

            <span>©2016 Pogoal</span>

        </div>{{-- .site-info --}}
    </footer>{{-- #footer --}}

    {{--<div class="debugBar">--}}
        {{--<ul class="list-inline">--}}
            {{--<li><a href="{{ url('groups') }}">Groups List</a></li>--}}
            {{--@if(Auth::check())--}}
                {{--<li><a href="{{ url('group/create') }}">Create a Group</a></li>--}}
                {{--<li><a href="{{ url('group') }}">Single Group</a></li>--}}
                {{--<li><a href="{{ URL::ROUTE('singleGroupProfilePage') }}">Group Profile</a></li>--}}
            {{--@endif--}}
        {{--</ul>--}}
    {{--</div>--}}

    <div id="outdated"></div>

    {{----------------------------
    | JS in Footer
    ----------------------------}}
    {!! Html::script("assets/js/libs/validator.min.js") !!}
    {!! Html::script("assets/js/libs/mustache.min.js") !!}
    {!! Html::script("assets/js/libs/slimscroll.min.js") !!}
    {!! Html::script("assets/js/libs/initial.min.js") !!}
    {!! Html::script("assets/js/libs/bootstrap-customized.min.js") !!}
    {!! Html::script("assets/js/main.min.js") !!}
    {!! Html::script("assets/js/api-feed.min.js") !!}
    {!! Html::script("assets/js/api-notifications.min.js") !!}
    {!! Html::script("assets/js/api-leaderboard.min.js") !!}
    @if(Auth::guest() && currentRoute('home'))
    {!! Html::script("assets/js/partials/slider.min.js") !!}
    @endif
    {!! Html::script("assets/js/temporary.js") !!}

    {{----------------------------
    | Google Analytics
    ----------------------------}}
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-82981600-1', 'auto');
        ga('send', 'pageview');
    </script>


</body>
</html>