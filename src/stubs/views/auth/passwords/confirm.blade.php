@extends('layouts.app')

@section('content')
    @component('components.full-page-section')

        <div class="notification">
            {{ __('Please confirm your password before continuing.') }}
        </div>

        @component('components.card')
            @slot('title')
                {{ __('Confirm Password') }}
            @endslot

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <div class="field">
                    <label class="label" for="password">{{ __('Password') }}</label>
                    <div class="control">
                        <input id="password" type="password" class="input @error('password') is-danger @enderror" name="password" required autocomplete="current-password">
                    </div>
                    @error('password')
                        <p class="help is-danger" role="alert">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <hr>

                <div class="field is-grouped">
                    <div class="control">
                        <button type="submit" class="button is-primary">
                            {{ __('Confirm Password') }}
                        </button>
                    </div>

                    @if (Route::has('password.request'))
                        <div class="control">
                            <a class="button is-text" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        </div>
                    @endif
                </div>
            </form>
        @endcomponent
    @endcomponent
@endsection
