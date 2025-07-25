<?php

namespace App\Console\Commands;

use App\Models\Coupon;
use Illuminate\Console\Command;

class ExpireCoupons extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:expire-coupons';

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
        Coupon::where('status', true)
            ->whereDate('end_date', '<', now())
            ->update(['status' => false]);
        $this->info('Expired coupons deactivated.');
    }
}
