@extends ('layout')

@section ('content')
<article>
    <h1 class="top">Login<div></div>
    </h1>
    <section class="body">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{ Form::open(['route' => 'users.do_login', 'class' => 'page_form']) }}
        <table>
            <tr>
                <td><label for="username">{{ __('Username') }}</label></td>
                <td>
                    <input type="text" name="username" id="username" placeholder="{{ __('Your username') }}" />
                </td>
            </tr>
            <tr>
                <td><label for="password">{{ __('Password') }}</label></td>
                <td>
                    <input type="password" name="password" id="password" placeholder="{{ __('Your password') }}" />
                </td>
            </tr>
        </table>

        <center>
            <div id="remember_me">
                <label for="remember">{{ __('Remember me') }}</label>
                <input type="checkbox" name="remember" id="remember" />
            </div>

            <input type="submit" name="login_submit" value="{{ __('Login') }}" />

            {{-- {if $has_smtp} --}}
            <section id="forgot">
                <a href="{$url}password_recovery">{{ __('Lost your password?') }}</a>
            </section>
            {{-- {/if} --}}
        </center>
        {{ Form::close() }}
    </section>
</article>
@endsection
