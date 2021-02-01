<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Ban;

class CheckForExipredBans extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:checkforexipredbans';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron to check for exipired bans';

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
        $bans = Ban::where('ends', '<', time())->where('ends', '!=', '-1')->whereNull('removetype')->get();

        foreach($bans as $ban)
        {
            $this->info("Removing ban for ". $ban->authid);
            $ban->removetype = "E";
            $ban->removetime = time();
            $ban->save();
        }
        $this->info("Command success");
    }
}
