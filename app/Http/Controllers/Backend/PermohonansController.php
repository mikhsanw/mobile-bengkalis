<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class PermohonansController extends Controller
{
    public function index()
    {
        return view('backend.'.$this->kode.'.index');
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            $data= $this->model::with('opd')->get();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', '<div style="text-align: center;">
               <a class="edit ubah" data-toggle="tooltip" data-placement="top" title="Edit" '.$this->kode.'-id="{{ $id }}" href="#edit-{{ $id }}">
                   <i class="fa fa-edit text-warning"></i>
               </a>&nbsp; &nbsp;
               <a class="delete hidden-xs hidden-sm hapus" data-toggle="tooltip" data-placement="top" title="Delete" href="#hapus-{{ $id }}" '.$this->kode.'-id="{{ $id }}">
                   <i class="fa fa-trash text-danger"></i>
               </a>
           </div>')->toJson();
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
		$data=[
			'opd_id'	=> \App\Model\Opd::pluck('nama','id'),
		];

        return view('backend.'.$this->kode.'.tambah' ,$data);
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
					'no_identitas' => 'required|'.config('master.regex.json'),
					'nama' => 'required|'.config('master.regex.json'),
					'alamat' => 'required|'.config('master.regex.json'),
					'email' => 'required|'.config('master.regex.json'),
					'no_telp' => 'required|'.config('master.regex.json'),
					'pekerjaan' => 'required|'.config('master.regex.json'),
					'rincian_informasi' => 'required|'.config('master.regex.json'),
					'tujuan_penggunaan' => 'required|'.config('master.regex.json'),
					'opd_id' => 'required|'.config('master.regex.json'),
					'cara_memperoleh' => 'required|'.config('master.regex.json'),
					'salinan_informasi' => 'required|'.config('master.regex.json'),
					'cara_mendapatkan' => 'required|'.config('master.regex.json'),
                    'identitas' => 'required',
                ]);
            if ($validator->fails()) {
                $respon=['status'=>false, 'pesan'=>$validator->messages()];
            }
            else {
                $data = $this->model::create($request->all());
                if ($request->hasFile('identitas')) {
                    $data->file()->create([
                        'name'                  => 'identitas',
                        'data'                      =>  [
                            'disk'      => config('filesystems.default'),
                            'target'    => Storage::putFile($this->kode.'/identitas/'.date('Y').'/'.date('m').'/'.date('d'),$request->file('identitas')),
                        ]
                    ]);
                }
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
			'opd_id'	=> \App\Model\Opd::pluck('nama','id'),

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
                	'no_identitas' => 'required|'.config('master.regex.json'),
					'nama' => 'required|'.config('master.regex.json'),
					'alamat' => 'required|'.config('master.regex.json'),
					'email' => 'required|'.config('master.regex.json'),
					'no_telp' => 'required|'.config('master.regex.json'),
					'pekerjaan' => 'required|'.config('master.regex.json'),
					'rincian_informasi' => 'required|'.config('master.regex.json'),
					'tujuan_penggunaan' => 'required|'.config('master.regex.json'),
					'opd_id' => 'required|'.config('master.regex.json'),
					'cara_memperoleh' => 'required|'.config('master.regex.json'),
					'salinan_informasi' => 'required|'.config('master.regex.json'),
					'cara_mendapatkan' => 'required|'.config('master.regex.json'),
            ]);
            if ($validator->fails()) {
                $response=['status'=>FALSE, 'pesan'=>$validator->messages()];
            }
            else {
                if($data = $this->model::find($id)){
                    $data->update($request->all());
                    if ($request->hasFile('identitas')) {
                        $data->file()->updateOrCreate(['name'=>'identitas'],[
                            'name'                  => 'identitas',
                            'data'                      =>  [
                                'disk'      => config('filesystems.default'),
                                'target'    => Storage::putFile($this->kode.'/identitas/'.date('Y').'/'.date('m').'/'.date('d'),$request->file('identitas')),
                            ]
                        ]);
                    }
                }
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