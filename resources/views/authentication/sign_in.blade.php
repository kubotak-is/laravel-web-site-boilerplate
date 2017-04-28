<form method="POST" action="{!! route('auth.post.sign_in') !!}" accept-charset="UTF-8">
    <dl>
        <dt>email</dt>
        <dd>
            <input name="email" type="email" required placeholder="{{ 'hoge@hoge.com' }}" value="{{ old('email') }}">
            @if($errors->has('email'))
                {{ $errors->first('email') }}
            @endif
        </dd>
    </dl>
    <dl>
        <dt>password</dt>
        <dd>
            <input name="password" type="password" required>
            @if($errors->has('password'))
                {{ $errors->first('password') }}
            @endif
        </dd>
    </dl>
    <input name="_token" type="hidden" value="{!! csrf_token() !!}">
    <button type="submit">SignIn</button>
</form>

<a href="{{ route('auth.get.sign_up') }}">Sign Up</a>
<br>
<a href="{{ route('auth.twitter') }}">Twitter</a>
<br>
<a href="{{ route('auth.facebook') }}">Facebook</a>
<br>
<a href="{{ route('auth.google') }}">Google</a>
<br>
<a href="{{ route('auth.github') }}">Github</a>