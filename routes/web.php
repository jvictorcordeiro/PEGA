<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\DepositoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MovimentoController;
use App\Http\Controllers\NotificacaoController;
use App\Http\Controllers\NotasController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\SolicitacaoController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::get('sistema', function () {
    return view('infos.sistema');
})->name('sistema');
Route::get('parceria', function () {
    return view('infos.parceria');
})->name('parceria');
Route::get('contato', function () {
    return view('infos.contato');
})->name('contato');

Route::middleware(['auth', 'verified', 'CheckCargoAdministrador'])->group(function () {
    Route::resource('notificacao', NotificacaoController::class);
    Route::get('notificacao/{notificacao_id}', [NotificacaoController::class, 'show'])->name('notificacao.show');
    Route::get('notificacoes', [NotificacaoController::class, 'index'])->name('notificacao.index');

    Route::get('material/index_edit', [MaterialController::class, 'indexEdit'])->name('material.indexEdit');
    Route::get('material/{id}/remover', [MaterialController::class, 'destroy'])->name('material.deletar');

    Route::get('nova_entrada_form', [MovimentoController::class, 'createEntrada'])->name('movimento.entradaCreate');
    Route::get('nova_saida_form', [MovimentoController::class, 'createSaida'])->name('movimento.saidaCreate');
    Route::get('transferencia_form', [MovimentoController::class, 'createTransferencia'])->name('movimento.transferenciaCreate');

    Route::post('movimento_entrada', [MovimentoController::class, 'entradaStore'])->name('movimento.entradaStore');
    Route::post('movimento_saida', [MovimentoController::class, 'saidaStore'])->name('movimento.saidaStore');
    Route::post('movimento_transferencia', [MovimentoController::class, 'transferenciaStore'])->name('movimento.transferenciaStore');

    Route::resource('deposito', DepositoController::class);
    Route::get('deposito/{id}/remover', [DepositoController::class, 'destroy'])->name('deposito.destroy');

    Route::resource('cargo', CargoController::class);

    Route::resource('solicita', SolicitacaoController::class);
    Route::get('analise_solicitacoes', [SolicitacaoController::class, 'listSolicitacoesAnalise'])->name('analise.solicitacoes');
    Route::POST('analise_solicitacoes', [SolicitacaoController::class, 'checkAnaliseSolicitacao'])->name('analise.solicitacao');

    Route::get('deletar_estoque/{id}', [DepositoController::class, 'deletarEstoque']);

    Route::get('cadastrar_nota', [NotasController::class, 'cadastrar'])->name('cadastrar.nota');
    Route::get('configurar_notas', [NotasController::class, 'configurar'])->name('config.nota');
    Route::post('alterar_config_notas', [NotasController::class, 'alterarConfig'])->name('alterar_config.nota');
    Route::post('criar_nota', [NotasController::class, 'create'])->name('criar.nota');
    Route::get('nota_materiais_edit', [NotasController::class, 'notaMateriaisEdit'])->name('materiais_edit.nota');
    Route::get('remover_material_nota/{id}', [NotasController::class, 'removerNotaMaterial'])->name('remover_material.nota');
    Route::post('adicionar_material_nota', [NotasController::class, 'adicionarMaterial'])->name('adicionar_material.nota');

    Route::get('nota', [NotasController::class, 'indexEdit'])->name('index.nota');
    Route::get('nota/edit/{id}', [NotasController::class, 'edit'])->name('edit.nota');
    Route::post('nota/update', [NotasController::class, 'update'])->name('update.nota');
    Route::get('nota/consulta', [NotasController::class, 'consultar'])->name('consult.nota');
    Route::get('nota/remover/{id}', [NotasController::class, 'remover'])->name('remover.nota');

    Route::post('ajaxAdicionarEmitente', [NotasController::class, 'adicionarEmitente'])->name('adicionar_emitente.nota');

});

Route::middleware(['auth', 'verified', 'CheckCargoRequerente'])->group(function () {
    Route::resource('solicita', SolicitacaoController::class);
    Route::get('editar_perfil/{user_id}', [UsuarioController::class, 'edit'])->name('perfil.editar');
    Route::get('solicita_material', [SolicitacaoController::class, 'show'])->name('solicita.material');
    Route::get('minhas_solicitacoes', [SolicitacaoController::class, 'listSolicitacoesRequerente'])->name('minhas.solicitacoes');
    Route::get('itens_solicitacao/{id}', [SolicitacaoController::class, 'getItemSolicitacaoRequerente'])->name('itens.solicitacao');
    Route::get('cancelar_solicitacao/{id}', [SolicitacaoController::class, 'cancelarSolicitacaoReq'])->name('cancelar.solicitacao');
});

Route::middleware(['auth', 'verified', 'CheckCargoAdminDiretoria'])->group(function () {
    Route::get('relatorio.materiais', [RelatorioController::class, 'relatorio_escolha'])->name('relatorio.materiais');
    Route::POST('relatorio.materiais', [RelatorioController::class, 'gerarRelatorioMateriais'])->name('relatorio.materiais');
});

Route::middleware(['auth', 'verified', 'CheckCargoAdminTerceirizado'])->group(function () {
    Route::get('entrega_materiais', [SolicitacaoController::class, 'listSolicitacoesAprovadas'])->name('entrega.materiais');
    Route::POST('entrega_materiais', [SolicitacaoController::class, 'checkEntregarMateriais'])->name('entrega.materiais');
    Route::get('consultarDeposito', [DepositoController::class, 'consultarDepositoView'])->name('deposito.consultarDeposito');
    Route::resource('material', MaterialController::class)->except(['show']);
    Route::get('solicitacoes_admin', [SolicitacaoController::class, 'listTodasSolicitacoes'])->name('solicitacoe.admin');
    Route::get('get_estoques/{deposito_id}', [DepositoController::class, 'getEstoques'])->name('deposito.getEstoque');
});

Route::middleware('auth', 'verified')->group(function () {
    Route::resource('usuario', UsuarioController::class);
    Route::get('usuario/{id}/edit_perfil', [UsuarioController::class, 'edit_perfil'])->name('usuario.edit_perfil');
    Route::get('usuario/{id}/edit_senha', [UsuarioController::class, 'edit_senha'])->name('usuario.edit_senha');
    Route::get('usuario/{id}/remover', [UsuarioController::class, 'destroy'])->name('usuario.destroy');
    Route::get('usuario/{id}/restaurar', [UsuarioController::class, 'restore'])->name('usuario.restore');
    Route::put('usuario/update_perfil/{id}', [UsuarioController::class, 'update_perfil'])->name('usuario.update_perfil');
    Route::put('usuario/update_senha/{id}', [UsuarioController::class, 'update_senha'])->name('usuario.update_senha');

    Route::get('/', function () {
        return view('home');
    })->name('home');

    Route::get('observacao_solicitacao/{id}', [SolicitacaoController::class, 'getObservacaoSolicitacao'])->name('observacao.solicitacao');
    Route::get('itens_solicitacao_admin/{id}', [SolicitacaoController::class, 'getItemSolicitacaoAdmin'])->name('itens.solicitacao.admin');
    Route::get('notas_material/{id}', [NotasController::class, 'getNotasList'])->name('nota.material');
});


Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);

    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);

    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('email/verify', [VerificationController::class, 'show'])->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
    Route::post('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');
