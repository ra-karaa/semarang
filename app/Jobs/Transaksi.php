<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Http;
use DB;

class Transaksi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

            DB::table('data_transaksis')->truncate();
            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', 'https://wmbankingramli.lp2m.unmul.ac.id/api/data-transaksi');
            $bodyJson = $response->json('data');
            DB::table('data_transaksis')->insert($bodyJson);
    }
}
