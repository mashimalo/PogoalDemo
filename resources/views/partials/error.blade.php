<div class="uiAlert uiAlert--{{ $type }} uiAlert--dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert">
        <span aria-hidden="true">&times;</span>
        <span class="hidden-text">{{ trans('front/uiAlert.close') }}</span>
    </button>
    <span class="uiAlert__icon icon icon-{{ $type }}"></span>
    <div class="uiAlert__content text-left small">
        <p>{!! $message !!}</p>
    </div>
</div>