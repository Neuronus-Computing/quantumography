<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\FilePass;
use App\Models\TemporaryFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File as FileSystem;

class DeleteExpiredFilesPass extends Command
{
    protected $signature = 'delete:expired-files';
    protected $description = 'Delete expired FilePass records and corresponding files';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Delete expired FilePass records and corresponding files from server
        $this->deleteExpiredFilePass();

        // Delete temporary files uploaded more than 1 day ago
        $this->deleteExpiredTemporaryFiles();

        $this->info('Expired files and records deleted successfully.');
    }

    protected function deleteExpiredFilePass()
    {
        $expiredFiles = FilePass::where('expiration_date', '<', now())->get();
        $directory ='';
        foreach ($expiredFiles as $file) {
            $pathAfterStorage = 'public/'.Str::after($file->path, 'storage/');
            $directory = pathinfo($pathAfterStorage, PATHINFO_DIRNAME);
            // Delete file from server storage
            Storage::delete($pathAfterStorage);
            // Delete file record from the database
            $file->delete();
        }
        $this->deleteEmptyDirectories($directory);
    }

    protected function deleteExpiredTemporaryFiles()
    {
        $expiredTemporaryFiles = TemporaryFile::where('created_at', '<', now()->subDay())->get();
        $directory ='';
        foreach ($expiredTemporaryFiles as $temporaryFile) {
            $directory = pathinfo($temporaryFile->path, PATHINFO_DIRNAME);
            // Delete temporary file from server storage
            Storage::delete($temporaryFile->path);
            // Delete temporary file record from the database
            $temporaryFile->delete();
        }
        $this->deleteEmptyDirectories($directory);
    }
    protected function deleteEmptyDirectories($directory)
    {
        // Check if the directory is empty
        if (Storage::directories($directory) === [] && Storage::files($directory) === []) {
            // Delete the directory
            Storage::deleteDirectory($directory);
        }
    }
}
