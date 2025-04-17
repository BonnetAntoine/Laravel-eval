<?php

namespace App\Classes\Dump;

use DateInterval;
use DateTime;
use Illuminate\Contracts\Container\BindingResolutionException;
use InvalidArgumentException;
use ZipArchive;

/**
 * @codeCoverageIgnore
 */
class Dump
{
    /**
     * @var string
     */
    private $nb_days_to_keep;

    /**
     * @var bool
     */
    private $is_zipped;

    public function __construct(string $nb_days_to_keep = '30', bool $is_zipped = false)
    {
        $this->nb_days_to_keep = $nb_days_to_keep;
        $this->is_zipped = $is_zipped;
    }

    /**
     * Création d'un dump de la base de données en fonction et suppression des fichiers hors période de rétention
     *
     * @return void
     *
     * @throws InvalidArgumentException
     * @throws BindingResolutionException
     */
    public function dump(): void
    {
        $user = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        $host = config('database.connections.mysql.host');
        $db_name = config('database.connections.mysql.database');
        // $user = env('DB_USERNAME');
        // $password = env('DB_PASSWORD');
        // $host = env('DB_HOST');
        // $db_name = env('DB_DATABASE');

        $limit = 'P' . $this->nb_days_to_keep . 'D';
        $date = new DateTime();
        $file = $date->format('Y-m-d-H-i-s');
        $start_date = $date->sub(new DateInterval($limit));

        $path = base_path('dump/');

        $files = scandir($path);
        if ($files === false) {
            \Log::error('Failed to read the directory: ' . $path);

            return;
        }

        $files = array_diff($files, ['..', '.']);
        foreach ($files as $file) {
            if (is_numeric(substr($file, 0, 4))) {
                $file_date = DateTime::createFromFormat('Y-m-d', substr($file, 0, 10));
                if ($file_date < $start_date) {
                    unlink($path . $file);
                }
            }
        }

        exec("mysqldump --user={$user} --password={$password} --host={$host} {$db_name} > {$path}{$file}.sql");

        if ($this->is_zipped) {
            $zip = new ZipArchive();
            if ($zip->open($path . $file . '.zip', ZipArchive::CREATE) !== true) {
                exit(1);
            }
            $zip->addFile("{$path}{$file}.sql", "{$file}.sql");
            $zip->close();

            unlink($path . $file . '.sql');
        }
    }
}
