@extends('core::admin.master')

@section('title', __('users::global.Log in'))

@section('page-header')
@endsection
@section('sidebar')
@endsection
@section('mainClass')
@endsection
@section('errors')
@endsection

@section('main')

<div id="login" class="container-login container-xs-center">

    @include('users::_status', ['closable' => false])

    {!! BootForm::open() !!}

        <h1>@lang('users::global.Log in')</h1>

        {!! BootForm::email(__('validation.attributes.email'), 'email')->addClass('input-lg')->autofocus(true) !!}
        {!! BootForm::password(__('validation.attributes.password'), 'password')->addClass('input-lg') !!}

        <div class="form-group">
            {!! BootForm::checkbox(__('validation.attributes.remember'), 'remember') !!}
        </div>

        <div class="form-group">
            {!! BootForm::submit(__('users::global.Log in'), 'btn-primary')->addClass('btn-lg btn-block') !!}
        </div>

        <div class="form-group">
            <span class="help-block">
                <a href="{{ route('resetpassword') }}">@lang('users::global.Forgot your password?')</a>
            </span>
        </div>

    {!! BootForm::close() !!}

</div>

@endsection
