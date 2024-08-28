<?php

namespace App\Console\Commands;

use App\Models\Timestamp;
use Carbon\Carbon;
use Illuminate\Console\Command;

class OvernightStatusChange extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'overnight-status-change';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'automatically refresh the index page at the start of each new day.';

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
        $today = Carbon::now()->format('Y-m-d');
        [$records, $fixedDate] = Timestamp::getRecordsWithDate($today);

        foreach ($records as $userName => $userRecords) {
            if (is_null($userRecords['work_end'])) {
                route('index');
            }
        }
    }
}
