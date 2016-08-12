<div id="slider" class="slider">
    <div class="hero-sliders">
        <div class="hero-slider">
            <div class="hero-slider-imgs">
                <div class="hero-slider-img" style="background-image:url('{{ url('/assets/images/hero-slide-1.jpg') }}');"></div>
            </div>

            <div class="hero-slider-contents">
                <div class="hero-slider-content">
                    <div class="hero-slider-title text-uppercase mB text-shadow">
                        Welcome to Pogoal
                    </div>
                    <div class="mB--lg text-lg text-shadow">
                        The social platform for startups, You can...
                    </div>
                    <div class="uiCallout center-table mB">
                        <div class="uiCallout__article">
                            Share, validate and get feedback for your ideas
                        </div>
                        <button class="uiCallout__button btn btn-primary" data-scroll="scroll" data-target="#content">
                            Join a Group
                        </button>
                    </div>
                    <div class="uiCallout center-table mB">
                        <div class="uiCallout__article">
                            Create your own startup groups
                        </div>
                        <a href="{{ URL::route ('singleGroupCreatePage-show') }}" class="uiCallout__button btn btn-primary">
                            Create a Group
                        </a>
                    </div>
                    <div class="uiCallout center-table mB">
                        <div class="uiCallout__article">
                            Start a joint conversation with other groups
                        </div>
                        <a href="#" class="uiCallout__button btn btn-primary">
                            Bridge a Group
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="hero-slider hidden">
            <div class="hero-slider-imgs">
                <div class="hero-slider-img" style="background-image:url('{{ url('/assets/images/hero-slide-2.jpg') }}');"></div>
            </div>

            <div class="hero-slider-contents">
                <div class="hero-slider-content">
                    <div class="hero-slider-title text-uppercase mB--lg text-shadow">
                        Find Your Passion
                    </div>
                    <a href="{{ url('auth/register') }}" class="btn btn-md btn-primary text-md bold mB--xxxlg arc-btn-rounded">
                        Find a group
                    </a>
                </div>
            </div>
        </div>
    </div>

    <button class="slider-scroll-down btn btn-square btn-square--md btn-outline-white rounded"
            data-scroll="scroll"
            data-target="#content"
            data-scroll-to-target="true">
        <span class="icon icon-arrow-down"></span>
    </button>
</div>