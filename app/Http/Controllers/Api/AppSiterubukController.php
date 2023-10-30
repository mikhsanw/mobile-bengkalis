<?php

namespace App\Http\Controllers\Api;

use App\Model\Opd;
use App\Model\Permohonan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AppSiterubukController extends Controller
{
    public function opd(){
        $data = Opd::all();
        return response()->json($data);
    }
    public function storepermohonan(Request $request)
    {
        $validator=Validator::make($request->all(), [
                'no_identitas' => 'required|'.config('master.regex.number'),
                'nama' => 'required|'.config('master.regex.json'),
                'fileidentitas' => 'required',
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
            $data = Permohonan::create($request->all());
            if ($request->fileidentitas) {
                $image_64 = $request->fileidentitas; //your base64 encoded data
                $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];
                $replace = substr($image_64, 0, strpos($image_64, ',')+1);
                $image = str_replace($replace, '', $image_64);
                $image = str_replace(' ', '+', $image);
                $image = base64_decode($image);

                $data->file()->create([
                    'name'                  => 'fileidentitas',
                    'data'                      =>  [
                        'disk'      => config('filesystems.default'),
                        'target'    => Storage::putFile('permohonan/fileidentitas/'.date('Y').'/'.date('m').'/'.date('d'),new File($image)),
                    ]
                ]);
            }
            $respon=['status'=>true, 'pesan'=>'Permohonan berhasil disimpan'];
        }
        return $respon;
    }
}
