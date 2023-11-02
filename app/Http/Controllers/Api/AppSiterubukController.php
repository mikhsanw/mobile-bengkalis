<?php

namespace App\Http\Controllers\Api;

use App\Model\Opd;
use App\Model\Permohonan;
use Illuminate\Http\File;
use App\Model\DataInformasi;
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
                $imageName = 'permohonan/fileidentitas/'.date('Y').'/'.date('m').'/'.date('d').'/'.uniqid().'.'.$extension;
                if(Storage::put($imageName,$image)){
                    $data->file()->create([
                        'name'                  => 'fileidentitas',
                        'data'                      =>  [
                            'disk'      => config('filesystems.default'),
                            'target'    => $imageName,
                        ]
                    ]);
                };
            }
            $respon=['status'=>true, 'pesan'=>'Permohonan berhasil disimpan'];
        }
        return $respon;
    }

    public function datainformasi(Request $request){
        $page = ($request->page ?? 1)-1;
        $limit = 5;
        $offset = $page * $limit;
        $values = DataInformasi::where('nama','LIKE','%'.$request->cari.'%')->latest()->offset($offset)->limit($limit)->get();
        $data = $values->map(function($val) {
            return [
                'id' => $val->id,
                'nama' => $val->nama,
                'opd' => $val->opd->nama,
                'view' => $val->view,
                'dokumen' => $val->file->url_stream,
                'created_at' => $val->created_at
            ];
        });
        return response()->json($data);
    }

    public function tentang(){
        $data = [
            'data'=>"<p>Created By Diskominfotik</p><br>tessssss",
        ];
        return $data;
    }
}
