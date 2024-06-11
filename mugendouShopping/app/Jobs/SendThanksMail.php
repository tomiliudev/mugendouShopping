<?php

namespace App\Jobs;

use App\Mail\ThanksMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendThanksMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $shopInfo = [];
    private $productInfos = [];

    /**
     * Create a new job instance.
     */
    public function __construct($shopInfo, $productInfos)
    {
        $this->shopInfo = $shopInfo;
        $this->productInfos = $productInfos;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->shopInfo['user']['email'])
            ->send(new ThanksMail($this->productInfos));
    }
}
