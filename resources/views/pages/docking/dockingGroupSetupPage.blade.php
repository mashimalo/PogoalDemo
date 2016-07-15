@extends('layouts.default-top')

@section('pageTitle')
    Bridging Setup
@stop

{{--- Content Top ---}}
@section('top')
    <div class="cover cover__bg cover--lg"
         style="background-image: url('{{ url('/assets/images/cover-abstract.jpg') }}');">
    </div>
@stop

{{--- Content ---}}
@section('content')
    @include('templates.docking.dockingGroupSetupPage-content')
@stop