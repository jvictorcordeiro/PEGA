@extends('layouts.auth')

@section('title', 'Redefinir Senha')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <h2 class="h5 mb-3">Redefinir senha</h2>

        <form method="POST" action="{{ route('password.update') }}" class="vstack gap-3">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div>
                <label for="email" class="form-label">E-mail</label>
                <input id="email" type="email" name="email" value="{{ $email ?? old('email') }}"
                       class="form-control @error('email') is-invalid @enderror" required autofocus>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div>
                <label for="password" class="form-label">Senha</label>
                <input id="password" type="password" name="password"
                       class="form-control @error('password') is-invalid @enderror" required autocomplete="new-password">
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div>
                <label for="password-confirm" class="form-label">Confirmar senha</label>
                <input id="password-confirm" type="password" name="password_confirmation" class="form-control" required autocomplete="new-password">
            </div>

            <button type="submit" class="btn btn-success">Redefinir senha</button>
        </form>
    </div>
</div>
@endsection
