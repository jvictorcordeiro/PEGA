<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpgradeAuditCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:upgrade-audit {--json : Exibe o relatório em JSON}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gera um inventário rápido de dependências legadas para a modernização do sistema';

    /**
     * Lista de pacotes que exigem revisão na modernização.
     *
     * @var array<int, array<string, string>>
     */
    protected $watchList = [
        [
            'scope' => 'composer',
            'package' => 'laravel/framework',
            'impact' => 'Framework legado',
            'recommendation' => 'Atualizar gradualmente até Laravel 12',
        ],
        [
            'scope' => 'composer',
            'package' => 'php',
            'impact' => 'Runtime antigo',
            'recommendation' => 'Subir para PHP 8.3+',
        ],
        [
            'scope' => 'composer',
            'package' => 'fzaninotto/faker',
            'impact' => 'Pacote abandonado',
            'recommendation' => 'Migrar para fakerphp/faker',
        ],
        [
            'scope' => 'composer',
            'package' => 'facade/ignition',
            'impact' => 'Stack de erro antiga',
            'recommendation' => 'Revalidar pacote conforme versão alvo do Laravel',
        ],
        [
            'scope' => 'composer',
            'package' => 'fideloper/proxy',
            'impact' => 'Configuração legada de proxy',
            'recommendation' => 'Revisar necessidade no Laravel moderno',
        ],
        [
            'scope' => 'composer',
            'package' => 'laravel/ui',
            'impact' => 'Scaffolding antigo de auth/UI',
            'recommendation' => 'Avaliar Breeze, Jetstream ou auth custom',
        ],
        [
            'scope' => 'npm',
            'package' => 'laravel-mix',
            'impact' => 'Pipeline legado de assets',
            'recommendation' => 'Migrar para Vite',
        ],
        [
            'scope' => 'npm',
            'package' => 'vue',
            'impact' => 'Framework de front legado',
            'recommendation' => 'Atualizar para Vue 3 ou reavaliar stack',
        ],
        [
            'scope' => 'npm',
            'package' => 'bootstrap',
            'impact' => 'Design system antigo',
            'recommendation' => 'Atualizar para Bootstrap 5+ ou Tailwind',
        ],
    ];

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $composerDependencies = $this->readDependencyFile(base_path('composer.json'), ['require', 'require-dev']);
        $npmDependencies = $this->readDependencyFile(base_path('package.json'), ['dependencies', 'devDependencies']);

        $findings = [];

        foreach ($this->watchList as $watchItem) {
            if ($watchItem['scope'] === 'composer' && isset($composerDependencies[$watchItem['package']])) {
                $findings[] = [
                    'categoria' => 'composer',
                    'pacote' => $watchItem['package'],
                    'versao' => $composerDependencies[$watchItem['package']],
                    'impacto' => $watchItem['impact'],
                    'recomendacao' => $watchItem['recommendation'],
                ];
            }

            if ($watchItem['scope'] === 'npm' && isset($npmDependencies[$watchItem['package']])) {
                $findings[] = [
                    'categoria' => 'npm',
                    'pacote' => $watchItem['package'],
                    'versao' => $npmDependencies[$watchItem['package']],
                    'impacto' => $watchItem['impact'],
                    'recomendacao' => $watchItem['recommendation'],
                ];
            }
        }

        if ($this->option('json')) {
            $this->line(json_encode($findings, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

            return 0;
        }

        if (empty($findings)) {
            $this->info('Nenhuma dependência legada da watchlist foi encontrada.');

            return 0;
        }

        $this->info('Inventário de modernização gerado com sucesso.');
        $this->table(
            ['Categoria', 'Pacote', 'Versão', 'Impacto', 'Recomendação'],
            array_map(function ($item) {
                return [
                    $item['categoria'],
                    $item['pacote'],
                    $item['versao'],
                    $item['impacto'],
                    $item['recomendacao'],
                ];
            }, $findings)
        );

        $this->comment('Próximo passo: criar tarefas de migração por pacote com estimativa e responsável.');

        return 0;
    }

    /**
     * @param  string  $filePath
     * @param  array<int, string>  $sections
     * @return array<string, string>
     */
    protected function readDependencyFile($filePath, array $sections)
    {
        if (! file_exists($filePath)) {
            return [];
        }

        $content = json_decode(file_get_contents($filePath), true);

        if (! is_array($content)) {
            return [];
        }

        $dependencies = [];

        foreach ($sections as $section) {
            if (isset($content[$section]) && is_array($content[$section])) {
                $dependencies = array_merge($dependencies, $content[$section]);
            }
        }

        return $dependencies;
    }
}
