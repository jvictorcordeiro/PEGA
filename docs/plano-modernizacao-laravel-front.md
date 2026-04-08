# Plano de modernização: Laravel (última versão) + Front-end

## Estado atual identificado no projeto

- **Laravel 7.x** (`laravel/framework: ^7.24`) e **PHP ^7.2.5**.
- Front-end legado com **Laravel Mix 5 + Webpack + Vue 2 + Bootstrap 4**.
- Dependências antigas/descontinuadas (ex.: `fzaninotto/faker`, `facade/ignition` em stack antiga).

Isso indica que a atualização direta para a versão mais nova do Laravel exige uma **migração em fases**.

## Meta técnica

- Migrar para **Laravel 12** (ou a release estável mais recente suportada no momento da execução).
- Atualizar runtime para **PHP 8.3+**.
- Migrar build de front para **Vite**.
- Atualizar front para stack moderna (sugestão: **Vue 3 + Bootstrap 5** ou **React + Tailwind**, conforme decisão de produto).

## Estratégia recomendada (baixo risco)

### Fase 1 — Preparação e inventário

1. Congelar branch de manutenção da versão atual.
2. Levantar pacotes incompatíveis e mapear substituições.
3. Criar suíte de testes mínima de fumaça (auth, CRUD principal, relatórios, filas/jobs).
4. Configurar pipeline CI com validação automática.

### Fase 2 — Upgrade do back-end (incremental)

Subir versão major do Laravel gradualmente para reduzir quebra:

- 7 -> 8 -> 9 -> 10 -> 11 -> 12

A cada salto:

1. Ajustar versão de PHP requerida.
2. Rodar guia oficial de upgrade da versão alvo.
3. Trocar pacotes obsoletos.
4. Executar testes e corrigir breaking changes.

### Fase 3 — Modernização de front-end

1. Migrar **Laravel Mix** para **Vite**.
2. Migrar componentes Vue 2 para Vue 3 (ou reescrever páginas em nova stack escolhida).
3. Atualizar design system (Bootstrap 5/Tailwind).
4. Revisar acessibilidade, responsividade e performance.

### Fase 4 — Hardening e Go-live

1. Benchmark de endpoints críticos.
2. Revisão de segurança (headers, rate limit, validações, sanitização).
3. Deploy canário + rollback automatizado.
4. Cutover final com janela de manutenção curta.

## Padrão de migração sugerido para este repositório

### Dependências (alvo)

- PHP: `^8.3`
- Laravel: `^12.0`
- Build: Vite + plugin Laravel
- Front: Vue 3 + `@vitejs/plugin-vue` (ou React, se preferirem)

### Pacotes que devem ser revisados imediatamente

- `fzaninotto/faker` -> `fakerphp/faker`
- `facade/ignition` (stack antiga) -> pacote compatível com Laravel alvo
- `laravel/ui` pode ser removido/migrado para Breeze/Jetstream ou auth custom
- `fideloper/proxy` e outros pacotes legados devem ser reavaliados conforme versão alvo

## Entregáveis por sprint

1. **Sprint 1:** Inventário + testes de fumaça + CI.
2. **Sprint 2:** Laravel 8/9 + PHP 8.1.
3. **Sprint 3:** Laravel 10/11 + estabilização.
4. **Sprint 4:** Laravel 12 + Vite + front modernizado.
5. **Sprint 5:** QA regressivo + performance + go-live.

## Critérios de aceite

- Build e deploy automáticos funcionando.
- Testes críticos passando com cobertura mínima acordada.
- Sem uso de dependências abandonadas.
- Lighthouse/Performance superior ao baseline do sistema legado.

## Próximo passo prático

Antes de iniciar alterações de código em massa, validar com o time:

1. Stack de front escolhida (Vue 3 ou React).
2. Estratégia de autenticação (Breeze/Jetstream/custom).
3. Janelas de deploy e tolerância a indisponibilidade.

Com isso aprovado, o time pode abrir a **Fase 1** imediatamente.

## Andamento da execução (atual)

- [x] Migração do build para **Vite** (`vite.config.js` + `@vite` nos layouts principais).
- [x] Migração inicial do front para **Vue 3** no entrypoint (`createApp`).
- [x] Atualização de middlewares para convenções modernas (`HandleCors`, `PreventRequestsDuringMaintenance`, `TrustProxies`).
- [x] Modernização do `RouteServiceProvider` com `RateLimiter`.
- [x] Migração de rotas para sintaxe `Controller::class` (preparando remoção completa de namespace legado).
- [ ] Instalar dependências e resolver conflitos de pacotes em ambiente com acesso aos registries.
- [ ] Executar suíte de testes completa e corrigir regressões.
- [x] Adicionado teste de rotas de autenticação (`AuthRoutesTest`) para proteger a refatoração de `Auth::routes`.
- [x] Refatoração inicial de autenticação: remoção de `Auth::routes` e definição explícita de rotas auth/verify/password.
- [x] Atualização inicial da UI de autenticação para layout moderno desacoplado (`layouts/auth.blade.php`).
- [ ] Próxima etapa de autenticação: migrar definitivamente para Breeze/Jetstream com componentes padrão.
