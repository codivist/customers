@extends('core::admin.master')

@section('page-header')
@stop
@section('sidebar')
@stop
@section('mainClass')
@stop
@section('errors')
@stop

@section('main')

<div id="login" class="container-login container-xs-center">

    @include('core::admin._message', ['closable' => false])

    {!! BootForm::open()->role('form') !!}
        {!! BootForm::token() !!}

        <h1>@lang('users::global.Log in')</h1>

        <div class="form-group">
            {!! Form::email('email')->addClass('form-control input-lg')->placeholder(trans('validation.attributes.email'))->autofocus(true) !!}
        </div>
        <div class="form-group">
            {!! Form::password('password')->addClass('form-control input-lg')->placeholder(trans('validation.attributes.password')) !!}
        </div>

        {!! BootForm::checkbox(trans('users::global.Remember me'), 'remember') !!}

        <div class="form-group">
            <span class="help-block">
                <a href="{{ route('resetpassword') }}">@lang('users::global.Forgot your password?')</a>
            </span>
        </div>

        <div class="form-group">
            {!! BootForm::submit(trans('validation.attributes.log in'), 'btn-primary')->addClass('btn-lg btn-block') !!}
        </div>

    {!! BootForm::close() !!}

</div>

@stop
