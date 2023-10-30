<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AppSiterubukController extends Controller
{
    public function store(Request $request)
    {
        dd($request->email);
        $validator=Validator::make($request->all(), [
                'no_identitas' => 'required|'.config('master.regex.number'),
                'nama' => 'required|'.config('master.regex.json'),
                'fileidentitas' => 'required|'.config('master.regex.gambar'),
                'alamat' => 'required|'.config('master.regex.json'),
                'email' => 'required|'.config('master.regex.email'),
                'no_telp' => 'required|'.config('master.regex.number'),
                'pekerjaan' => 'required|'.config('master.regex.json'),
                'rincian_informasi' => 'required|'.config('master.regex.json'),
                'tujuan_penggunaan' => 'required|'.config('master.regex.json'),
                'opd_id' => 'required|'.config('master.regex.json'),
                'cara_memperoleh' => 'required|'.config('master.regex.json'),
                'salinan_informasi' => 'required|'.config('master.regex.json'),
                'cara_mendapatkan' => 'required|'.config('master.regex.json'),
            ]);
        if ($validator->fails()) {
            $respon=['status'=>false, 'pesan'=>$validator->messages()];
        }
        else {
            $data = $this->model::create($request->all());
            if ($request->hasFile('fileidentitas')) {
                $data->file()->create([
                    'name'                  => 'fileidentitas',
                    'data'                      =>  [
                        'disk'      => config('filesystems.default'),
                        'target'    => Storage::putFile($this->kode.'/fileidentitas/'.date('Y').'/'.date('m').'/'.date('d'),$request->file('fileidentitas')),
                    ]
                ]);
            }
            $respon=['status'=>true, 'pesan'=>'Permohonan berhasil disimpan'];
        }
        return $respon;
    }
}
