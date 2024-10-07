<?php

namespace App\Console\Commands;

use App\Models\Gift;
use Illuminate\Console\Command;

class SendGiftCertificateNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gifts:send-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends notifications about gift certificate in specified delivery date';

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
     * @return void
     */
    public function handle(): void
    {
        $unsentGifts = Gift::where('is_sent', false)
            ->whereDate('delivery_date', '<=', today())
            ->get();

        foreach ($unsentGifts as $unsentGift) {
            $unsentGift->sendGiftSentNotification();
        }
    }
}
