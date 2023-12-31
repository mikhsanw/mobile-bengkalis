<?php

namespace App\Http\Controllers\Api;

use App\Model\Berita;
use App\Model\AplikasiPemda;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SuperappsController extends Controller
{
    public function berita(request $req)
    {
        if($req->author == 'pbe'){
            $beritas = Berita::limit(10)->get();
            $data = $beritas->map(function($berita) {
                return [
                    'id' => $berita->id,
                    'nama' => $berita->nama,
                    'isi' => $berita->isi,
                    'tanggal' => $berita->tanggal,
                    'view' => $berita->view,
                    'foto' => $berita->file->url_stream,
                ];
            });
            return response()->json(['message' => 'Success','data' => $data], 200);
        }else{
            return response()->json(['error' => 'Operation failed'], 500);
        }
    }
    public function aplikasipemda(request $req)
    {
        if($req->author == 'pbe'){
            $values = AplikasiPemda::whereJenis($req->jenis)->get();
            $data = $values->map(function($val) {
                return [
                    'id' => $val->id,
                    'nama' => $val->nama,
                    'keterangan' => $val->keterangan,
                    'opd' => $val->opd->nama,
                    'link' => $val->link,
                    'foto' => $val->file->url_stream,
                    'jenis' => $val->jenis
                ];
            });
            return response()->json(['message' => 'Success','data' => $data], 200);
        }else{
            return response()->json(['error' => 'Operation failed'], 500);
        }
    }
    public function cariaplikasipemda(request $req)
    {
        if($req->author == 'pbe'){
            $values = AplikasiPemda::where('nama','LIKE','%'.$req->cari.'%')->limit(10)->get();
            $data = $values->map(function($val) {
                return [
                    'id' => $val->id,
                    'nama' => $val->nama,
                    'keterangan' => $val->keterangan,
                    'opd' => $val->opd->nama,
                    'link' => $val->link,
                    'foto' => $val->file->url_stream,
                    'jenis' => $val->jenis
                ];
            });
            return response()->json(['message' => 'Success','data' => $data], 200);
        }else{
            return response()->json(['error' => 'Operation failed'], 500);
        }
    }
}
