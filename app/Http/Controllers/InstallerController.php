<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Exception;

class InstallerController extends Controller
{
    /**
     * Exibir página de boas-vindas do instalador
     */
    public function welcome()
    {
        if ($this->isInstalled()) {
            return redirect('/');
        }
        
        return view('installer.welcome');
    }

    /**
     * Verificar requisitos do sistema
     */
    public function requirements()
    {
        if ($this->isInstalled()) {
            return redirect('/');
        }

        $requirements = [
            'php' => [
                'name' => 'PHP >= 8.2',
                'status' => version_compare(PHP_VERSION, '8.2.0', '>='),
                'version' => PHP_VERSION
            ],
            'extensions' => [
                'pdo' => [
                    'name' => 'PDO',
                    'status' => extension_loaded('pdo')
                ],
                'pdo_pgsql' => [
                    'name' => 'PDO PostgreSQL',
                    'status' => extension_loaded('pdo_pgsql')
                ],
                'mbstring' => [
                    'name' => 'Mbstring',
                    'status' => extension_loaded('mbstring')
                ],
                'zip' => [
                    'name' => 'Zip',
                    'status' => extension_loaded('zip')
                ],
                'curl' => [
                    'name' => 'cURL',
                    'status' => extension_loaded('curl')
                ],
                'gd' => [
                    'name' => 'GD',
                    'status' => extension_loaded('gd')
                ],
            ]
        ];

        return view('installer.requirements', compact('requirements'));
    }

    /**
     * Verificar permissões de pastas
     */
    public function permissions()
    {
        if ($this->isInstalled()) {
            return redirect('/');
        }

        $envPath = base_path('.env');
        $envExists = file_exists($envPath);
        $envWritable = $envExists && is_writable($envPath);

        $permissions = [
            'storage/framework' => is_writable(storage_path('framework')),
            'storage/logs' => is_writable(storage_path('logs')),
            'storage/app' => is_writable(storage_path('app')),
            'bootstrap/cache' => is_writable(base_path('bootstrap/cache')),
            '.env' => $envWritable,
        ];

        return view('installer.permissions', compact('permissions'));
    }

    /**
     * Configurar banco de dados
     */
    public function database()
    {
        if ($this->isInstalled()) {
            return redirect('/');
        }

        return view('installer.database');
    }

    /**
     * Testar conexão com banco de dados
     */
    public function testDatabase(Request $request)
    {
        $request->validate([
            'db_host' => 'required',
            'db_port' => 'required|numeric',
            'db_name' => 'required',
            'db_username' => 'required',
        ]);

        try {
            $connection = "pgsql:host={$request->db_host};port={$request->db_port};dbname={$request->db_name}";
            $pdo = new \PDO($connection, $request->db_username, $request->db_password);
            
            return response()->json([
                'success' => true,
                'message' => 'Conexão estabelecida com sucesso!'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro na conexão: ' . $e->getMessage()
            ], 400);
        }
    }

    /**
     * Salvar configurações do banco de dados no .env
     */
    public function saveDatabase(Request $request)
    {
        $request->validate([
            'db_host' => 'required',
            'db_port' => 'required|numeric',
            'db_name' => 'required',
            'db_username' => 'required',
        ]);

        try {
            // Atualizar .env
            $this->updateEnv([
                'DB_CONNECTION' => 'pgsql',
                'DB_HOST' => $request->db_host,
                'DB_PORT' => $request->db_port,
                'DB_DATABASE' => $request->db_name,
                'DB_USERNAME' => $request->db_username,
                'DB_PASSWORD' => $request->db_password,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Configurações salvas com sucesso!'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao salvar configurações: ' . $e->getMessage()
            ], 400);
        }
    }

    /**
     * Criar usuário administrador
     */
    public function admin()
    {
        if ($this->isInstalled()) {
            return redirect('/');
        }

        return view('installer.admin');
    }

    /**
     * Finalizar instalação
     */
    public function install(Request $request)
    {
        if ($this->isInstalled()) {
            return redirect('/');
        }

        $request->validate([
            'admin_name' => 'required|string|max:255',
            'admin_email' => 'required|email|max:255',
            'admin_password' => 'required|min:8|confirmed',
            'site_name' => 'required|string|max:255',
        ]);

        try {
            // Atualizar nome do site no .env
            $this->updateEnv([
                'APP_NAME' => '"' . $request->site_name . '"',
                'APP_ENV' => 'production',
                'APP_DEBUG' => 'false',
            ]);

            // Limpar cache de configuração
            Artisan::call('config:clear');

            // Executar migrations
            Artisan::call('migrate', ['--force' => true]);

            // Criar usuário administrador
            User::create([
                'name' => $request->admin_name,
                'email' => $request->admin_email,
                'password' => Hash::make($request->admin_password),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]);

            // Marcar como instalado
            File::put(storage_path('installed'), now()->toString());

            // Limpar cache
            Artisan::call('config:cache');
            Artisan::call('route:cache');
            Artisan::call('view:cache');

            return response()->json([
                'success' => true,
                'message' => 'Instalação concluída com sucesso!',
                'redirect' => '/login'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro durante a instalação: ' . $e->getMessage()
            ], 400);
        }
    }

    /**
     * Verificar se o sistema já foi instalado
     */
    private function isInstalled()
    {
        return File::exists(storage_path('installed'));
    }

    /**
     * Atualizar variáveis no arquivo .env
     */
    private function updateEnv(array $data)
    {
        $envFile = base_path('.env');
        
        // Verificar se o arquivo .env existe
        if (!file_exists($envFile)) {
            throw new Exception(
                'Arquivo .env não encontrado. ' .
                'Em ambientes Docker, verifique se o entrypoint está sendo executado corretamente. ' .
                'Em instalações locais, copie o arquivo .env.example para .env'
            );
        }
        
        // Verificar se o arquivo .env é gravável
        if (!is_writable($envFile)) {
            throw new Exception(
                'Sem permissão de escrita no arquivo .env. ' .
                'Docker: Verifique os logs do container com "docker logs <container-name>". ' .
                'Local: Execute "chmod 664 ' . $envFile . '" ou "chown www-data:www-data ' . $envFile . '"'
            );
        }

        $env = file_get_contents($envFile);

        foreach ($data as $key => $value) {
            $pattern = "/^{$key}=.*/m";
            $replacement = "{$key}={$value}";

            if (preg_match($pattern, $env)) {
                $env = preg_replace($pattern, $replacement, $env);
            } else {
                $env .= "\n{$replacement}";
            }
        }

        $result = file_put_contents($envFile, $env);
        
        if ($result === false) {
            throw new Exception(
                'Falha ao escrever no arquivo .env. Verifique as permissões do arquivo e do diretório.'
            );
        }
    }
}
