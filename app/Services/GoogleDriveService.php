<?php

namespace App\Services;

use Google\Client;
use Google\Service\Drive;
use Illuminate\Support\Facades\Log;

class GoogleDriveService
{
    protected $client;
    protected $driveService;
    protected $folderId;
    protected $ownerEmail;

    public function __construct()
    {
        $this->folderId = env('GOOGLE_DRIVE_FOLDER_ID', '1kd42TCSegSa1orCvV5dPbA8lClZkcz2X');
        $this->ownerEmail = env('GOOGLE_DRIVE_OWNER_EMAIL');
        
        $this->client = new Client();
        $this->client->setApplicationName('Plataforma Practicas Profesionales FIE');
        $this->client->setScopes([Drive::DRIVE]);

        // Evitar que el servidor se cuelgue si hay problemas de conexión con Google
        $guzzleOptions = [
            'timeout' => 15.0,
            'connect_timeout' => 5.0,
        ];

        // En desarrollo local (Windows), PHP carece de los certificados de autoridades (CA).
        // Desactivamos temporalmente la verificación SSL sólo si el entorno es local para evitar cURL error 60.
        if (config('app.env') === 'local') {
            $guzzleOptions['verify'] = false;
        }

        $guzzleClient = new \GuzzleHttp\Client($guzzleOptions);
        $this->client->setHttpClient($guzzleClient);

        $credentialsJson = env('GOOGLE_DRIVE_CREDENTIALS_JSON');
        $credentialsPath = env('GOOGLE_DRIVE_CREDENTIALS_PATH');

        // Resolver la ruta absoluta en caso de que sea una ruta relativa
        $resolvedPath = $credentialsPath;
        if ($credentialsPath && !str_starts_with($credentialsPath, '/') && !preg_match('/^[A-Z]:\\\\/i', $credentialsPath)) {
            $resolvedPath = base_path($credentialsPath);
        }

        if ($credentialsJson) {
            $this->client->setAuthConfig(json_decode($credentialsJson, true));
        } elseif ($resolvedPath && file_exists($resolvedPath)) {
            $this->client->setAuthConfig($resolvedPath);
        } else {
            // Log warning, do not crash so local development is preserved
            Log::warning('Google Drive credentials are not configured in .env. Uploads will fallback to local storage.');
        }

        // Initialize drive service only if auth config has been loaded to avoid exceptions
        try {
            $this->driveService = new Drive($this->client);
        } catch (\Exception $e) {
            Log::warning('Could not initialize Google Drive Service: ' . $e->getMessage());
        }
    }

    /**
     * Uploads a file to Google Drive and returns the file ID and shareable web link.
     * Returns null if API credentials are not configured (triggers fallback).
     */
    public function uploadFile($filePath, $fileName, $mimeType = 'application/pdf')
    {
        if (empty(env('GOOGLE_DRIVE_CREDENTIALS_JSON')) && empty(env('GOOGLE_DRIVE_CREDENTIALS_PATH'))) {
            Log::info("Google Drive API bypass: Local fallback activated for {$fileName}");
            return null;
        }

        if (!$this->driveService) {
            Log::error('Google Drive Service is not initialized due to missing credentials.');
            return null;
        }

        try {
            // 1. Crear el archivo vacío (0 bytes) en la carpeta de Drive
            $fileMetadata = new Drive\DriveFile([
                'name' => $fileName,
                'parents' => [$this->folderId]
            ]);

            // Crear el archivo sin pasar datos para que pese 0 bytes y no rebote por cuota de Service Account
            $file = $this->driveService->files->create($fileMetadata, [
                'fields' => 'id,webViewLink'
            ]);
            $fileId = $file->id;

            // 2. Transferir la propiedad del archivo al dueño de la carpeta (tu cuenta de Google)
            if (!empty($this->ownerEmail)) {
                try {
                    $permission = new Drive\Permission([
                        'type' => 'user',
                        'role' => 'owner',
                        'emailAddress' => $this->ownerEmail,
                    ]);
                    $this->driveService->permissions->create($fileId, $permission, [
                        'transferOwnership' => true
                    ]);
                } catch (\Exception $ownerEx) {
                    Log::warning('No se pudo transferir la propiedad del archivo al dueño real de Drive: ' . $ownerEx->getMessage());
                }
            }

            // 3. Subir el contenido real del archivo (ahora consume la cuota del dueño real, no de la Service Account)
            $content = file_get_contents($filePath);
            $emptyMetadata = new Drive\DriveFile();

            $file = $this->driveService->files->update($fileId, $emptyMetadata, [
                'data' => $content,
                'mimeType' => $mimeType,
                'uploadType' => 'multipart',
                'fields' => 'id,webViewLink'
            ]);

            // 4. Establecer permisos para que cualquier persona con el vínculo pueda leerlo
            try {
                $permission = new Drive\Permission([
                    'type' => 'anyone',
                    'role' => 'reader',
                ]);
                $this->driveService->permissions->create($fileId, $permission);
            } catch (\Exception $permEx) {
                Log::warning('Could not set public view permissions on uploaded Drive file: ' . $permEx->getMessage());
            }

            return [
                'id' => $file->id,
                'link' => $file->webViewLink
            ];
        } catch (\Exception $e) {
            Log::error('Google Drive API Upload Error: ' . $e->getMessage());
            throw $e;
        }
    }
}
