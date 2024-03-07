<?php

namespace App\Console\Commands;

use App\Model\Wilayah;
use Illuminate\Console\Command;

class NkriGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:nkri-generator {kode?} {level?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate NKRI data from API';

    private $apiProvinsi = 'https://emsifa.github.io/api-wilayah-indonesia/api/provinces.json';
    private $apiKabupaten = 'https://emsifa.github.io/api-wilayah-indonesia/api/regencies/{kode}.json';
    private $apiKecamatan = 'https://emsifa.github.io/api-wilayah-indonesia/api/districts/{kode}.json';
    private $apiKelurahan = 'https://emsifa.github.io/api-wilayah-indonesia/api/villages/{kode}.json';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $kode = $this->argument('kode');
        $level = $this->argument('level');
        if ($kode && $level=='kabupaten') {
            $this->generateKabupaten($kode);
        }else if ($kode && $level=='kecamatan') {
            $this->generateKecamatan($kode);
        }else if ($kode && $level=='kelurahan') {
            $this->generateKelurahan($kode);
        }else {
            $this->generateProvinsi();
        }
    }

    private function apiHandler($url, $kode = null)
    {
        if ($kode) {
            $url = str_replace('{kode}', $kode, $url);
        }
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $url);
        $body = $response->getBody();
        $data = json_decode($body, true);
        return $data;
    }

    private function generateProvinsi()
    {
        $data = $this->apiHandler($this->apiProvinsi);
        $this->info('Generating Provinsi...');
        foreach ($data as $provinsi) {
            $this->info('Provinsi: ' . $provinsi['name']);
            $prov = Wilayah::updateOrCreate([
                'kode' => $provinsi['id'],
                'level' => 'provinsi',
            ], [
                'nama' => $provinsi['name'],
            ]);
            $this->generateKabupaten($provinsi['id'], $prov);
        }
    }

    private function generateKabupaten(mixed $kode, $provinsi=null)
    {
        $data = $this->apiHandler($this->apiKabupaten, $kode);
        $this->info('Generating Kabupaten...');
        foreach ($data as $kabupaten) {
            $this->info('Kabupaten: ' . $kabupaten['name']);
            if(is_null($provinsi)) {
                $provinsi = Wilayah::where('kode', $kabupaten['province_id'])->first();
            }
            $kab = $provinsi->updateOrCreate([
                'kode' => $kabupaten['id'],
                'level' => 'kabupaten',
            ], [
                'nama' => $kabupaten['name'],
                'parent_id' => $provinsi->id,
            ]);
            $this->generateKecamatan($kabupaten['id'], $kab);
        }
    }

    private function generateKecamatan(mixed $kode, $kab=null)
    {
        $data = $this->apiHandler($this->apiKecamatan, $kode);
        $this->info('Generating Kecamatan...');
        foreach ($data as $kecamatan) {
            $this->info('Kecamatan: ' . $kecamatan['name']);
            if(is_null($kab)) {
                $kab = Wilayah::where('kode', $kecamatan['regency_id'])->first();
            };
            $kec = $kab->updateOrCreate([
                'kode' => $kecamatan['id'],
                'level' => 'kecamatan',
            ], [
                'nama' => $kecamatan['name'],
                'parent_id' => $kab->id,
            ]);
            $this->generateKelurahan($kecamatan['id'], $kec);
        }
    }

    private function generateKelurahan(mixed $kode, $kec)
    {
        $data = $this->apiHandler($this->apiKelurahan, $kode);
        $this->info('Generating Kelurahan...');
        foreach ($data as $kelurahan) {
            $this->info('Kelurahan: ' . $kelurahan['name']);
            $kec->updateOrCreate([
                'kode' => $kelurahan['id'],
                'level' => 'kelurahan',
            ], [
                'nama' => $kelurahan['name'],
                'parent_id' => $kec->id,
            ]);
        }
    }
}
