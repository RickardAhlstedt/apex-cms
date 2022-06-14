<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class BuildMenuCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'menu:cache {group} {--depth=0} {--parent=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Builds a cache for a given menu';

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
        $iDepth = $this->option('depth');
        $iParent = $this->option('parent');

        $oRender = new \App\Render\Menu();
        ob_start();
        $oRender->buildMenu( $iParent, $iDepth, $sGroup );
        $sMenu = ob_get_clean();

        Cache::put( 'menu_' . $sGroup, $sMenu );

        $this->info( 'Menu-cache for group ' . $sGroup . ' built.' );

        return 0;
    }
}
