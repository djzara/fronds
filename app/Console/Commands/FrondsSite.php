<?php

namespace Fronds\Console\Commands;

use Illuminate\Console\Command;

/**
 * TODO: remove coverage flag when implemented
 * Class FrondsSite
 * @package Fronds\Console\Commands
 * @codeCoverageIgnore
 */
class FrondsSite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fronds:site';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return mixed
     */
    public function handle()
    {
        //
    }
}
