@extends('layouts.app')

@section('content')
    @component('components.full-page-section')

        @if (session('status'))
            <div class="notification is-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        @component('components.card')
            @slot('title')
                {{ __('Reset Password') }}
            @endslot

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="field">
                    <label class="label" for="email">{{ __('E-Mail Address') }}</label>
                    <div class="control">
                        <input id="email" type="email" class="input @error('email') is-danger @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    </div>

                    @error('email')
                        <p class="help is-danger" role="alert">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <hr>

                <div class="field is-grouped">
                    <div class="control">
                        <button type="submit" class="button is-primary">
                            {{ __('Send Password Reset Link') }}
                        </button>
                    </div>
                    <div class="control">
                        <a class="button is-text" href="{{ route('login') }}">
                            {{ __('Back') }}
                        </a>
                    </div>
                </div>

            </form>

        @endcomponent
    @endcomponent
@endsection
