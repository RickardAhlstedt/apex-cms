<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ClearMenuCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'menu:clear {group}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clears a given menu-cache';

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
        $sGroup = $this->argument('group');
        // Search the cache for the given group
        if( Cache::has( 'menu_' . $sGroup ) ) {
            Cache::forget( 'menu_' . $sGroup );
            $this->info( 'Menu-cache for group ' . $sGroup . ' cleared.' );
        } else {
            $this->error( 'Menu-cache for group ' . $sGroup . ' not found.' );
        }
        return 0;
    }
}
