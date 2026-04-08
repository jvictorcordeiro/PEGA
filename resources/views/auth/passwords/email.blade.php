@extends('layouts.auth')

@section('title', 'Redefinir Senha')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <h2 class="h5 mb-3">Solicitar redefinição de senha</h2>

        @if (session('status'))
            <div class="alert alert-success" role="alert">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="vstack gap-3">
            @csrf
            <div>
                <label for="email" class="form-label">E-mail</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                       class="form-control @error('email') is-invalid @enderror" required autofocus>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn btn-success">Enviar link de redefinição</button>
        </form>
    </div>
</div>
@endsection
