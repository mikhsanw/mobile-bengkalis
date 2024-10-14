<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class KegiatanKimsController extends Controller
{
    public function index()
    {
        return view('backend.'.$this->kode.'.index');
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            $data= $this->model::with('kim','kim_anggota')->byLevelKim()->get();
            return Datatables::of($data)->addIndexColumn()
                ->editColumn('jenis',fn($q)=>config('master.level_kegiatan_kim.'.$q->jenis))
                ->addColumn('action', function($q){
                    $id = $q->id;
                    $kode = $this->kode;
                    return (Auth::user()->kim_anggota)?'<div style="text-align: center;">
                        <a class="edit ubah" data-toggle="tooltip" data-placement="top" title="Edit" '.$kode.'-id="' . $id . '" href="#edit-' . $id . '">
                            <i class="fa fa-edit text-warning"></i>
                        </a>&nbsp; &nbsp;
                        <a class="delete hidden-xs hidden-sm hapus" data-toggle="tooltip" data-placement="top" title="Delete" '.$kode.'-id="' . $id . '" href="#hapus-' . $id . '">
                            <i class="fa fa-trash text-danger"></i>
                        </a>
                    </div>':'<div style="text-align: center;">
                        <a class="delete hidden-xs hidden-sm hapus" data-toggle="tooltip" data-placement="top" title="Delete" '.$kode.'-id="' . $id . '" href="#hapus-' . $id . '">
                            <i class="fa fa-trash text-danger"></i>
                        </a>
                    </div>';
                })->toJson();
        }
        else {
            exit("Not an AJAX request -_-");
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('backend.'.$this->kode.'.tambah');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->ajax()) {
            $validator=Validator::make($request->all(), [
					'nama' => 'required|'.config('master.regex.json'),
					'lokasi' => 'required|'.config('master.regex.json'),
					'tanggal' => 'required|'.config('master.regex.json'),
					'jenis' => 'required|'.config('master.regex.json'),
					'deskripsi' => 'required|'.config('master.regex.json'),
                ]);
            if ($validator->fails()) {
                $respon=['status'=>false, 'pesan'=>$validator->messages()];
            }
            else {
                $request->merge([
                    'kim_id'=>$request->user()->kim_anggota->kim_id
                ]);
                $this->model::create($request->all());
                $respon=['status'=>true, 'pesan'=>'Data berhasil disimpan'];
            }
            return $respon;
        }
        else {
            exit('Ops, an Ajax request');
        }
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data=[
            'data'    => $this->model::find($id),

        ];
        return view('backend.'.$this->kode.'.ubah', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->ajax()) {
            $validator=Validator::make($request->all(), [
                					'nama' => 'required|'.config('master.regex.json'),
					'lokasi' => 'required|'.config('master.regex.json'),
					'tanggal' => 'required|'.config('master.regex.json'),
					'jenis' => 'required|'.config('master.regex.json'),
					'deskripsi' => 'required|'.config('master.regex.json'),
					'kim_id' => 'required|'.config('master.regex.json'),
            ]);
            if ($validator->fails()) {
                $response=['status'=>FALSE, 'pesan'=>$validator->messages()];
            }
            else {
                $this->model::find($id)->update($request->all());
                $respon=['status'=>true, 'pesan'=>'Data berhasil diubah'];
            }
            return $response ?? ['status'=>TRUE, 'pesan'=>['msg'=>'Data berhasil diubah']];
        }
        else {
            exit('Ops, an Ajax request');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function hapus($id)
    {
        $data=$this->model::find($id);
        return view('backend.'.$this->kode.'.hapus', ['data'=>$data]);
    }

    public function destroy($id)
    {
        $data=$this->model::find($id);
        if ($data->delete()) {
            $response=['status'=>TRUE, 'pesan'=>['msg'=>'Data berhasil dihapus']];
        }
        else {
            $response=['status'=>FALSE, 'pesan'=>['msg'=>'Data gagal dihapus']];
        }
        return response()->json($response);
    }
}