@extends('layout.master')
@section('content')
<div class="fronds-row col-12">
    @include('widgets.actions.menus')
    @include('widgets.actions.pages')
    @include('widgets.actions.content')
    @include('widgets.actions.images')
    @include('widgets.actions.theme')
</div>
@stop