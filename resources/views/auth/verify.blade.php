@extends('layouts.auth')

@section('title', 'Verificar E-mail')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <h2 class="h5 mb-3">Verificação de e-mail</h2>

        @if (session('resent'))
            <div class="alert alert-success" role="alert">
                Um novo link de verificação foi enviado para seu endereço de e-mail.
            </div>
        @endif

        <p class="mb-2">Antes de continuar, verifique seu e-mail para obter um link de verificação.</p>
        <p class="mb-0">
            Se você não recebeu o e-mail,
            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button type="submit" class="btn btn-link p-0 align-baseline">clique aqui para solicitar outro</button>
            </form>
        </p>
    </div>
</div>
@endsection
