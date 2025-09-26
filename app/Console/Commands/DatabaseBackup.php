<?php

namespace App\Console\Commands;



use App\Models\ConfigGeneral;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Spatie\DbDumper\Databases\MySql;

class DatabaseBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
{

    // $config = ConfigGeneral::all()->first();

    // $filename = '\backup_'.env('DB_DATABASE').'_'.date('Y').''.date('m').''.date('d').'_'.date('H').'_'.date('i').'_'.date('s').'.sql';

    // //File::put($filename, '');

    // MySql::create()
    //     ->setDumpBinaryPath(env('DUMP_BINARY_PATH'))
    //     ->setDbName(env('DB_DATABASE'))
    //     ->setUserName(env('DB_USERNAME'))
    //     ->setPassword(env('DB_PASSWORD'))
    //     ->setHost(env('DB_HOST'))
    //     ->setPort(env('DB_PORT'))
    //     ->dumpToFile($config->ruta_salva.''.$filename);

    //     $filename = "backup-" . Carbon::now()->format('Y-m-d') . ".sql";

    // Create backup folder and set permission if not exist.
    // $storageAt = storage_path() . "/app/backup/";
    // if(!File::exists($storageAt))
    // File::makeDirectory($storageAt, 0755, true, true);


    // $command = "".env('DB_DUMP_PATH', 'mysqldump').
    //             " --user=" . env('DB_USERNAME') .
    //             " --password=" . env('DB_PASSWORD') .
    //             " --host=" . env('DB_HOST') .
    //             " --dbname" . env('DB_DATABASE').
    //             " --dumpbinarypath" . env('DUMP_BINARY_PATH');
}
}
