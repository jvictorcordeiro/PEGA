@extends('layouts.auth')

@section('title', 'Cadastre-se')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body p-4 p-md-5">
        <h2 class="h4 mb-4">Cadastre-se</h2>

        <form method="POST" action="{{ route('register') }}" class="vstack gap-4">
            @csrf

            <section>
                <h3 class="h6 text-muted text-uppercase">Dados pessoais</h3>
                <div class="row g-3">
                    <div class="col-12">
                        <label for="nome" class="form-label">Nome</label>
                        <input id="nome" type="text" name="nome" maxlength="100" value="{{ old('nome') }}"
                               class="form-control @error('nome') is-invalid @enderror" required>
                        @error('nome')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label for="cpf" class="form-label">CPF</label>
                        <input id="cpf" type="text" name="cpf" value="{{ old('cpf') }}"
                               class="form-control @error('cpf') is-invalid @enderror" required placeholder="000.000.000-00">
                        @error('cpf')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label for="rg" class="form-label">RG</label>
                        <input id="rg" type="text" name="rg" maxlength="11" value="{{ old('rg') }}"
                               class="form-control @error('rg') is-invalid @enderror" required>
                        @error('rg')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label for="data_nascimento" class="form-label">Data de nascimento</label>
                        <input id="data_nascimento" type="date" name="data_nascimento" min="1910-01-01"
                               value="{{ old('data_nascimento') }}" class="form-control @error('data_nascimento') is-invalid @enderror">
                        @error('data_nascimento')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </section>

            <section>
                <h3 class="h6 text-muted text-uppercase">Contato</h3>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="email" class="form-label">E-mail</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                               class="form-control @error('email') is-invalid @enderror" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="numTel" class="form-label">Número de celular</label>
                        <input id="numTel" type="text" name="numTel" value="{{ old('numTel') }}"
                               class="form-control @error('numTel') is-invalid @enderror" required placeholder="(00)00000-0000">
                        @error('numTel')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </section>

            <section>
                <h3 class="h6 text-muted text-uppercase">Informações institucionais</h3>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="matricula" class="form-label">Matrícula</label>
                        <input id="matricula" type="text" maxlength="11" name="matricula" value="{{ old('matricula') }}"
                               class="form-control @error('matricula') is-invalid @enderror" required>
                        @error('matricula')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="setor" class="form-label">Setor</label>
                        <select id="setor" class="form-select" name="setor">
                            <option value="Administrativo">Administrativo</option>
                            <option value="Academico">Acadêmico</option>
                            <option value="Administrativo/Academico">Administrativo/Acadêmico</option>
                        </select>
                    </div>
                </div>
            </section>

            <section>
                <h3 class="h6 text-muted text-uppercase">Dados de login</h3>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="password" class="form-label">Senha</label>
                        <input id="password" type="password" name="password"
                               class="form-control @error('password') is-invalid @enderror" required autocomplete="new-password">
                        <small class="text-muted">A senha deve possuir ao menos 8 caracteres.</small>
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="password-confirm" class="form-label">Confirmar senha</label>
                        <input id="password-confirm" type="password" name="password_confirmation" class="form-control" required autocomplete="new-password">
                    </div>
                </div>
            </section>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">Cadastrar-se</button>
                <a href="{{ route('login') }}" class="btn btn-outline-secondary">Voltar para login</a>
            </div>
        </form>
    </div>
</div>
@endsection
