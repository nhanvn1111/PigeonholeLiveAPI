<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Orders\OrderService;
class UpdatePigeon extends Command
{

    protected $orderService;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pigeone:exec';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update status pigeone when finish my delivery and downtime for rest';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(OrderService $orderService)
    {
        parent::__construct();
        $this->orderService = $orderService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->orderService->updateStatus();
        logger()->info("Execute draw.");
    }
}
