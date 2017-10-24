<form method="POST" action="/password/reset">
    {!! csrf_field() !!}
    <input type="hidden" name="token" value="{{ $token }}">

    <div>
        Email
        <input type="email" name="email" value="{{ old('email') }}">
    </div>

    <div>
        Senha
        <input type="password" name="password">
    </div>

    <div>
        Confirme a Senha
        <input type="password" name="password_confirmation">
    </div>

    <div>
        <button type="submit">
            Reset Senha
        </button>
    </div>
</form>