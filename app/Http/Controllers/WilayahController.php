<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WilayahController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->get('id') ?? null;
        return view($this->view.'.index', compact('id'));
    }

    public function create(Request $request)
    {
        $id = $request->get('id') ?? null;
        return view($this->view.'.create', compact('id'));
    }

    public function data(Request $request)
    {
        $user = $request->user();
        if ($request->get('id')) {
            $data = $this->model::where('parent_id', $request->get('id'));
        } else {
            $data = $this->model::provinsi();
        }
        return datatables()->of($data)
            ->addColumn('action', function ($data) use ($user) {
                $button ='';
                if($user->read){
                    $button .= '<a href="'.$this->url.'?id='.$data->id.'" class="btn btn-sm btn-outline" data-title="Detail" title="lihat turunan data ini"><i class="fa fa-external-link text-info"></i></a>';
                }
                if($user->read){
                    $button .= '<button type="button" class="btn-action btn btn-sm btn-outline" data-title="Detail" data-action="show" data-url="'.$this->url.'" data-id="'.$data->id.'" title="Tampilkan"><i class="fa fa-eye text-info"></i></button>';
                }
                if($user->update){
                    $button.='<button type="button" class="btn-action btn btn-sm btn-outline" data-title="Edit" data-action="edit" data-url="'.$this->url.'" data-id="'.$data->id.'" title="Edit"> <i class="fa fa-edit text-warning"></i> </button> ';
                }
                if($user->delete){
                    $button.='<button type="button" class="btn-action btn btn-sm btn-outline" data-title="Delete" data-action="delete" data-url="'.$this->url.'" data-id="'.$data->id.'" title="Delete"> <i class="fa fa-trash text-danger"></i> </button>';
                }
                return "<div class='btn-group'>".$button."</div>";
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make();
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required',
			'nama' => 'required',
			'level' => 'required',
        ]);

        if ($this->model::create($request->all())) {
            $response=[ 'status'=>TRUE, 'message'=>'Data berhasil disimpan'];
        }
        return response()->json($response ?? ['status'=>FALSE, 'message'=>'Data gagal disimpan']);
    }

    public function show($id)
    {
        $data = $this->model::find($id);
        return view($this->view.'.show', compact('data'));
    }

    public function edit($id)
    {
        $data = $this->model::find($id);
        return view($this->view.'.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode' => 'required',
			'nama' => 'required',
			'level' => 'required',
        ]);

        $data=$this->model::find($id);
        if($data->update($request->all())){
            $response=[ 'status'=>TRUE, 'message'=>'Data berhasil disimpan'];
        }
        return response()->json($response ?? ['status'=>FALSE, 'message'=>'Data gagal disimpan']);
    }

    public function delete($id)
    {
        $data=$this->model::find($id);
        return view($this->view.'.delete', compact('data'));
    }

    public function destroy($id)
    {
        $data=$this->model::find($id);
        if($data->delete()){
            $response=[ 'status'=>TRUE, 'message'=>'Data berhasil dihapus'];
        }
        return response()->json($response ?? ['status'=>FALSE, 'message'=>'Data gagal dihapus']);
    }

    public function getWilayah(Request $request)
    {
        $data = $this->model::where('parent_id', $request->get('id'))->get();
        return response()->json($data);
    }
}
