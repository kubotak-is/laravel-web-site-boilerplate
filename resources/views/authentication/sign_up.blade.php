
<form method="POST" action="{!! route('auth.post.sign_up') !!}" accept-charset="UTF-8">
    <dl>
        <dt>name</dt>
        <dd>
            <input name="name" type="text" required placeholder="name" value="{{ old('name') }}">
            @if($errors->has('name'))
                {{ $errors->first('name') }}
            @endif
        </dd>
    </dl>
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
    <dl>
        <dt>password confirm</dt>
        <dd>
            <input name="confirm" type="password" required>
            @if($errors->has('confirm'))
                {{ $errors->first('confirm') }}
            @endif
        </dd>
    </dl>
    <input name="_token" type="hidden" value="{!! csrf_token() !!}">
    <button type="submit">SignUp</button>
</form>