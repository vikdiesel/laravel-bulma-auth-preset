@extends('layouts.app')

@section('content')
    @component('components.full-page-section')
        @component('components.card')
            @slot('title')
                {{ config('app.name') }}
            @endslot

            <div class="content">
                <p>
                    Welcome to <b>{{ config('app.name') }}</b>
                </p>
                <p>
                    Please, <a href="{{ route('login') }}">login</a> or <a href="{{ route('register') }}">register</a>&hellip;
                </p>
            </div>
            <hr>
            <div class="buttons">
                <a href="{{ route('login') }}" class="button is-primary">Login</a>
                <a href="{{ route('register') }}" class="button is-text">Register</a>
            </div>
        @endcomponent
    @endcomponent
@endsection