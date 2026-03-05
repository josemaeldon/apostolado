<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StorageSettingsController extends Controller
{
    /**
     * Display the storage settings page.
     */
    public function index()
    {
        $currentDisk = $this->getPersistedEnvValue('FILESYSTEM_DISK', config('filesystems.default'));
        $storageSettings = [
            'minio_endpoint' => $this->getPersistedEnvValue('MINIO_ENDPOINT', config('filesystems.disks.minio.endpoint', 'http://minio:9000')),
            'minio_access_key' => $this->getPersistedEnvValue('MINIO_ACCESS_KEY_ID', config('filesystems.disks.minio.key', '')),
            'minio_secret_key' => $this->getPersistedEnvValue('MINIO_SECRET_ACCESS_KEY', config('filesystems.disks.minio.secret', '')),
            'minio_bucket' => $this->getPersistedEnvValue('MINIO_BUCKET', config('filesystems.disks.minio.bucket', 'apostolado')),
            'minio_region' => $this->getPersistedEnvValue('MINIO_REGION', config('filesystems.disks.minio.region', 'us-east-1')),
            'minio_url' => $this->getPersistedEnvValue('MINIO_URL', config('filesystems.disks.minio.url', '')),
        ];
        
        // Test connection to current disk
        $connectionStatus = $this->testConnection($currentDisk);
        
        return view('admin.storage-settings.index', compact('currentDisk', 'connectionStatus', 'storageSettings'));
    }

    /**
     * Update the storage settings.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'filesystem_disk' => 'required|in:local,public,s3,minio',
            'minio_endpoint' => 'nullable|string',
            'minio_access_key' => 'nullable|string',
            'minio_secret_key' => 'nullable|string',
            'minio_bucket' => 'nullable|string',
            'minio_region' => 'nullable|string',
            'minio_url' => 'nullable|string',
        ]);

        // Preserve existing values when fields are submitted empty.
        $existing = [
            'minio_endpoint' => $this->getPersistedEnvValue('MINIO_ENDPOINT', ''),
            'minio_access_key' => $this->getPersistedEnvValue('MINIO_ACCESS_KEY_ID', ''),
            'minio_secret_key' => $this->getPersistedEnvValue('MINIO_SECRET_ACCESS_KEY', ''),
            'minio_bucket' => $this->getPersistedEnvValue('MINIO_BUCKET', ''),
            'minio_region' => $this->getPersistedEnvValue('MINIO_REGION', 'us-east-1'),
            'minio_url' => $this->getPersistedEnvValue('MINIO_URL', ''),
        ];

        // Update .env file
        $this->updateEnvFile([
            'FILESYSTEM_DISK' => $validated['filesystem_disk'],
            'MINIO_ENDPOINT' => $this->resolveSubmittedValue($validated['minio_endpoint'] ?? null, $existing['minio_endpoint']),
            'MINIO_ACCESS_KEY_ID' => $this->resolveSubmittedValue($validated['minio_access_key'] ?? null, $existing['minio_access_key']),
            'MINIO_SECRET_ACCESS_KEY' => $this->resolveSubmittedValue($validated['minio_secret_key'] ?? null, $existing['minio_secret_key']),
            'MINIO_BUCKET' => $this->resolveSubmittedValue($validated['minio_bucket'] ?? null, $existing['minio_bucket']),
            'MINIO_REGION' => $this->resolveSubmittedValue($validated['minio_region'] ?? null, $existing['minio_region'] ?: 'us-east-1'),
            'MINIO_URL' => $this->resolveSubmittedValue($validated['minio_url'] ?? null, $existing['minio_url']),
            'MINIO_USE_PATH_STYLE_ENDPOINT' => 'true',
        ]);

        // Update runtime config for current request cycle and prevent stale UI status.
        config(['filesystems.default' => $validated['filesystem_disk']]);

        // Remove stale cached config so the app reads fresh .env values after update/restart.
        $this->clearConfigCacheFiles();

        return redirect()->route('admin.storage-settings.index')
            ->with('success', 'Configurações de armazenamento atualizadas com sucesso!');
    }

    /**
     * Test the connection to the storage.
     */
    public function test(Request $request)
    {
        $disk = $request->input('disk', config('filesystems.default'));
        $result = $this->testConnection($disk);
        
        return response()->json($result);
    }

    /**
     * Test connection to a specific disk.
     */
    private function testConnection($disk)
    {
        try {
            $storage = Storage::disk($disk);
            
            // Try to list files (this will fail if connection is bad)
            $storage->files();
            
            return [
                'success' => true,
                'message' => 'Conexão bem-sucedida!',
                'disk' => $disk,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Erro ao conectar: ' . $e->getMessage(),
                'disk' => $disk,
            ];
        }
    }

    /**
     * Update .env file with new values.
     */
    private function updateEnvFile(array $data)
    {
        $envFile = base_path('.env');
        $persistentEnvFile = storage_path('app/config/.env.persistent');
        
        if (!file_exists($envFile)) {
            \Log::error('Cannot update storage settings: .env file does not exist');
            throw new \RuntimeException('Configuration file not found. Please create .env file first.');
        }

        $envContent = file_get_contents($envFile);

        foreach ($data as $key => $value) {
            // Escape special characters in value for .env format
            $value = addslashes($value);
            $escapedKey = preg_quote($key, '/');
            
            // Check if key exists
            if (preg_match("/^{$escapedKey}=/m", $envContent)) {
                // Update existing key
                $envContent = preg_replace(
                    "/^{$escapedKey}=.*/m",
                    "{$key}=\"{$value}\"",
                    $envContent
                );
            } else {
                // Add new key at the end
                $envContent .= "\n{$key}=\"{$value}\"";
            }
        }

        // Use file locking to prevent race conditions
        file_put_contents($envFile, $envContent, LOCK_EX);

        // Keep a persistent mirror in storage volume so updates/redeploys can restore it.
        $persistentDir = dirname($persistentEnvFile);
        if (!is_dir($persistentDir)) {
            @mkdir($persistentDir, 0775, true);
        }

        file_put_contents($persistentEnvFile, $envContent, LOCK_EX);
    }

    /**
     * Read env values from persistent env file first, then fallback to .env.
     */
    private function getPersistedEnvValue(string $key, ?string $default = null): ?string
    {
        $sources = [
            storage_path('app/config/.env.persistent'),
            base_path('.env'),
        ];

        foreach ($sources as $file) {
            if (!is_file($file)) {
                continue;
            }

            $content = file_get_contents($file);
            if ($content === false) {
                continue;
            }

            $escapedKey = preg_quote($key, '/');
            if (preg_match('/^' . $escapedKey . '=(.*)$/m', $content, $matches)) {
                $value = trim($matches[1]);
                return trim($value, "\"'");
            }
        }

        return $default;
    }

    /**
     * Remove cached config artifacts that can keep old env values.
     */
    private function clearConfigCacheFiles(): void
    {
        $cacheFiles = [
            base_path('bootstrap/cache/config.php'),
            base_path('bootstrap/cache/services.php'),
            base_path('bootstrap/cache/packages.php'),
        ];

        foreach ($cacheFiles as $file) {
            if (is_file($file)) {
                @unlink($file);
            }
        }
    }

    /**
     * Keep the existing persisted value when submitted value is null/empty.
     */
    private function resolveSubmittedValue(?string $submitted, string $existing): string
    {
        if ($submitted === null) {
            return $existing;
        }

        $trimmed = trim($submitted);
        return $trimmed === '' ? $existing : $trimmed;
    }
}
