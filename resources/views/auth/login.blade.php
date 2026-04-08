@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body p-4 p-md-5">
        <div class="row g-4 align-items-start">
            <div class="col-md-7">
                <h2 class="text-primary fw-bold">Plataforma Eletrônica de Gestão de Almoxarifados (PEGA)</h2>
                <p class="text-muted">
                    Aplicação web para informatizar rotinas de almoxarifado, controle de estoque e atendimento de solicitações.
                </p>
                <ul class="text-muted mb-0">
                    <li>Mais praticidade e confiabilidade na gestão do setor.</li>
                    <li>Fluxo digital de solicitação, aprovação e entrega de materiais.</li>
                    <li>Acesso via internet com autenticação institucional.</li>
                </ul>
            </div>

            <div class="col-md-5">
                <h3 class="h4 mb-3">Entrar</h3>
                <form method="POST" action="{{ route('login') }}" class="vstack gap-3">
                    @csrf

                    <div>
                        <label for="email" class="form-label">E-mail</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                               class="form-control @error('email') is-invalid @enderror" required autocomplete="email" autofocus>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="form-label">Senha</label>
                        <input id="password" type="password" name="password"
                               class="form-control @error('password') is-invalid @enderror" required autocomplete="current-password">
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">Lembrar e-mail e senha</label>
                    </div>

                    <button type="submit" class="btn btn-success w-100">Entrar</button>

                    @if (Route::has('password.request'))
                        <a class="text-decoration-none text-center" href="{{ route('password.request') }}">Esqueci minha senha</a>
                    @endif

                    <a href="{{ route('register') }}" class="btn btn-outline-primary w-100">Cadastre-se</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
