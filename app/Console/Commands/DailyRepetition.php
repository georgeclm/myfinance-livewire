<?php

namespace App\Console\Commands;

use App\Http\Controllers\CicilanController;
use Illuminate\Console\Command;

class DailyRepetition extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cicilan:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cek Cicilan Untuk Tanggal Ini';

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
        $controller = new CicilanController();
        $controller->checkCicilanDaily();

        $this->info('This Worked');
    }
}
