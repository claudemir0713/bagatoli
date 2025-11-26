<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use ZipArchive;


class BackupDatabase extends Command
{
    protected $signature = 'backup:database';
    protected $description = 'Gera um backup do banco de dados MySQL, compacta e remove backups antigos';

    public function handle()
    {
        $backupPath = storage_path('app/backups');

        // Cria a pasta se não existir
        if (!File::exists($backupPath)) {
            File::makeDirectory($backupPath, 0755, true);
            $this->info("📂 Pasta criada: {$backupPath}");
        }

        // Nome do arquivo SQL
        $filename = 'backup_' . Carbon::now()->format('Y_m_d_His') . '.sql';
        $fullPath = $backupPath . '/' . $filename;

        // Dados do banco
        $dbHost = env('DB_HOST');
        $dbUser = env('DB_USERNAME');
        $dbPass = env('DB_PASSWORD');
        $dbName = env('DB_DATABASE');

        // Caminho do mysqldump vindo do .env
        $mysqldumpPath = env('MYSQLDUMP_PATH');

        // Comando mysqldump
        $command = "\"{$mysqldumpPath}\" --user={$dbUser} --password={$dbPass} --host={$dbHost} {$dbName} > \"{$fullPath}\"";
        exec($command);

        $this->info("✅ Backup gerado: {$fullPath}");

        // Compacta em ZIP
        $zipFilename = str_replace('.sql', '.zip', $filename);
        $zipPath = $backupPath . '/' . $zipFilename;

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
            $zip->addFile($fullPath, $filename);
            $zip->close();
            $this->info("📦 Backup compactado: {$zipPath}");
            // Remove arquivo SQL após compactar
            File::delete($fullPath);
        } else {
            $this->error("❌ Falha ao criar arquivo ZIP.");
        }

        // Remove backups mais antigos que 7 dias
        $files = File::files($backupPath);
        $now = Carbon::now();

        foreach ($files as $file) {
            if ($now->diffInDays(Carbon::createFromTimestamp($file->getMTime())) > 7) {
                File::delete($file->getRealPath());
                $this->info("🗑 Backup antigo removido: {$file->getFilename()}");
            }
        }
    }
}
