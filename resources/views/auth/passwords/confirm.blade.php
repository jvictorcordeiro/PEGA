@extends('layouts.auth')

@section('title', 'Confirmar Senha')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <h2 class="h5 mb-3">Confirme sua senha</h2>

        <form method="POST" action="{{ route('password.confirm') }}" class="vstack gap-3">
            @csrf
            <div>
                <label for="password" class="form-label">Senha</label>
                <input id="password" type="password" name="password"
                       class="form-control @error('password') is-invalid @enderror" required autocomplete="current-password">
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="d-flex gap-3 align-items-center">
                <button type="submit" class="btn btn-primary">Confirmar senha</button>
                @if (Route::has('password.request'))
                    <a class="btn btn-link p-0" href="{{ route('password.request') }}">Esqueceu a sua senha?</a>
                @endif
            </div>
        </form>
    </div>
</div>
@endsection
