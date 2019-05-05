@extends('layout.master')


@section('left-gutter')
    <div class="col-md-2">

            @include('layout.gutters.base-left-gutter')

    </div>

@stop

@section('content')

    <div class="fronds-widget-content col-md-12 justify-content-center text-center">
        <h2>{{ __('page.admin.title') }}</h2>
        <fronds-form dusk="fronds-login-form" id="fronds-login-form"
                     :horizontal="true">
            <div class="col-md-12 fronds-row">
                <div class="col-md-2"></div>
                <div class="fronds-row col-md-4">
                    <fronds-input id="fronds-admin-login-email"
                                  :input-label-classes="['mr-2']"
                                  input-label="{{ __('controls.input.admin.email') }}"></fronds-input>
                </div>
                <div class="fronds-row col-md-4">
                    <fronds-input id="fronds-admin-login-pass"
                                  :input-label-classes="['mr-2']"
                                  input-label="{{ __('controls.input.admin.password') }}"
                                  type="password"></fronds-input>
                </div>
            </div>


        </fronds-form>
        <div class="fronds-row col-md-12">
            <div class="col-md-8"></div>
            <div class="col-md-4">
                <fronds-button id="fronds-admin-login-btn"
                               btn-text="{{ __('controls.button.admin.login') }}"></fronds-button>
            </div>
        </div>
    </div>


@stop



@section ('right-gutter')

        @include('layout.gutters.base-right-gutter')


@stop