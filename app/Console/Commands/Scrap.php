<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Symfony\Component\HttpClient\HttpClient;

class Scrap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrap:run';

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
        $goutte = new \Goutte\Client(HttpClient::create(['timeout' => 60]));
        $crawler = $goutte->request('GET', 'https://admin.presensi.uny.ac.id/remun');
        $crawler->filter('.form-inline')->form();

        $form = $crawler->selectButton('Download')->form([
            'bulan-tahun' => '03-2021',
        ]);
        $crawler->submit($form);
    }
}
