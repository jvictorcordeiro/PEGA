#!/usr/bin/env bash
set -u

STEP="${1:-all}"
FAILED_STEPS=()

log() {
  printf "\n[upgrade] %s\n" "$1"
}

run_step() {
  local step_name="$1"
  shift

  if "$@"; then
    log "${step_name}: OK"
  else
    FAILED_STEPS+=("${step_name}")
    log "${step_name}: FALHOU (seguindo para próxima etapa)"
  fi
}

run_precheck() {
  log "Etapa 1/4 - Pré-check"
  php -v
  composer --version
  node -v
  npm -v

  if [[ ! -f .env ]]; then
    cp .env.example .env
    log "Arquivo .env criado a partir de .env.example"
  fi

  return 0
}

run_backend() {
  local failed=0

  log "Etapa 2/4 - Dependências backend"
  composer update || failed=1
  php artisan key:generate --ansi || failed=1
  php artisan config:clear || failed=1
  php artisan route:clear || failed=1
  php artisan view:clear || failed=1

  return "$failed"
}

run_frontend() {
  local failed=0

  log "Etapa 3/4 - Dependências frontend"
  npm install || failed=1
  npm run build || failed=1

  return "$failed"
}

run_validation() {
  local failed=0

  log "Etapa 4/4 - Validações"
  php artisan test || failed=1
  php artisan route:list || failed=1

  return "$failed"
}

print_summary() {
  if [[ ${#FAILED_STEPS[@]} -eq 0 ]]; then
    log "Resumo final: todas as etapas concluídas com sucesso"
    return 0
  fi

  log "Resumo final: etapas com falha -> ${FAILED_STEPS[*]}"
  return 1
}

case "$STEP" in
  precheck)
    run_step precheck run_precheck
    ;;
  backend)
    run_step backend run_backend
    ;;
  frontend)
    run_step frontend run_frontend
    ;;
  validation)
    run_step validation run_validation
    ;;
  all)
    run_step precheck run_precheck
    run_step backend run_backend
    run_step frontend run_frontend
    run_step validation run_validation
    ;;
  *)
    echo "Uso: $0 [precheck|backend|frontend|validation|all]"
    exit 1
    ;;
esac

print_summary
