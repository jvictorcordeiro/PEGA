# Execução sequencial da modernização

Este guia organiza os próximos passos em uma ordem única para facilitar a migração sem pular etapas.

## Ordem recomendada

1. **Pré-check de ambiente**
2. **Upgrade de dependências backend (Composer/Laravel)**
3. **Upgrade de dependências frontend (Node/Vite/Vue 3)**
4. **Validação (testes + rotas)**

## Script de apoio

Foi adicionado o script:

- `scripts/upgrade/run-sequencial.sh`

### Executar tudo

```bash
bash scripts/upgrade/run-sequencial.sh all
```

### Executar por etapa

```bash
bash scripts/upgrade/run-sequencial.sh precheck
bash scripts/upgrade/run-sequencial.sh backend
bash scripts/upgrade/run-sequencial.sh frontend
bash scripts/upgrade/run-sequencial.sh validation
```

## Resultado esperado por etapa

### 1) precheck
- Ver versões de PHP/Composer/Node/NPM
- Garantir existência do `.env`

### 2) backend
- `composer update`
- limpeza de cache do Laravel
- geração de chave se necessário

### 3) frontend
- `npm install`
- `npm run build`

### 4) validation
- `php artisan test`
- `php artisan route:list`

## Observação importante

Se houver bloqueio de rede (403/timeout), rode o mesmo fluxo em ambiente com acesso aos registries (Packagist e npm).


## Comportamento de execução

- No modo `all`, o script **segue para a próxima etapa mesmo se a etapa atual falhar**.
- Ao final, ele imprime um resumo com as etapas que falharam.
- O retorno final é `0` se tudo passou, e `1` se alguma etapa falhou.
