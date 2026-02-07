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
        $currentDisk = config('filesystems.default');
        
        // Test connection to current disk
        $connectionStatus = $this->testConnection($currentDisk);
        
        return view('admin.storage-settings.index', compact('currentDisk', 'connectionStatus'));
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

        // Update .env file
        $this->updateEnvFile([
            'FILESYSTEM_DISK' => $validated['filesystem_disk'],
            'MINIO_ENDPOINT' => $validated['minio_endpoint'] ?? '',
            'MINIO_ACCESS_KEY_ID' => $validated['minio_access_key'] ?? '',
            'MINIO_SECRET_ACCESS_KEY' => $validated['minio_secret_key'] ?? '',
            'MINIO_BUCKET' => $validated['minio_bucket'] ?? '',
            'MINIO_REGION' => $validated['minio_region'] ?? 'us-east-1',
            'MINIO_URL' => $validated['minio_url'] ?? '',
            'MINIO_USE_PATH_STYLE_ENDPOINT' => 'true',
        ]);

        return redirect()->route('admin.storage-settings.index')
            ->with('success', 'Configurações de armazenamento atualizadas com sucesso! Reinicie a aplicação para aplicar as mudanças.');
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
    }
}
