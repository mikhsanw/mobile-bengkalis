<?php

namespace App\Http\Controllers\Backend;

use App\Model\Kim;
use App\Model\User;
use App\Model\Aksesgrup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class KimAnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.'.$this->kode.'.index');
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            $user=$this->model::with('user')->byLevelKim();
            return Datatables::of($user)->addIndexColumn()
                ->addColumn('action', function ($data){
                    return '<div class="text-center text-nowrap">
                               <a class="edit ubah pr-2" data-toggle="tooltip" data-placement="top" title="Edit" '.$this->kode.'-id="'.$data->id.'" href="#edit-'.$data->id.'">
                                   <i class="fa fa-edit text-warning"></i>
                               </a>
                               <a class="delete hidden-xs hidden-sm hapus" data-toggle="tooltip" data-placement="top" title="Delete" href="#hapus-'.$data->id.'" '.$this->kode.'-id="'.$data->id.'">
                                   <i class="fa fa-trash text-danger"></i>
                               </a>
                           </div>';
                })->rawColumns(['action'])->make(TRUE);
        }
        else {
            exit("Not an AJAX request -_-");
        }
    }

    public function create()
    {
        $data = [
            'kim_id'  => Kim::pluck('nama', 'id'),
        ];
        return view('backend.'.$this->kode.'.tambah',$data);
    }

    public function store(Request $request)
    {
        $validator=Validator::make($request->all(), [
            'nama'=>'required|string|max:255', 'username'=>'required|string|max:50|unique:users', 'password'=>'min:6', 'kim_id'=>'required', 'level_kim'=>'required',
        ]);
        if ($validator->fails()) {
            $response=['status'=>FALSE, 'pesan'=>$validator->messages()];
        }
        else {
            $request->request->add(['aksesgrup_id'=>2]);
            $request->request->add(['level'=>0]);

            if ($user = User::create($request->all())) {
                $this->model::create(['level_kim'=>$request->level_kim,'user_id'=>$user->id,'kim_id'=>$request->kim_id]);
                $response=['status'=>TRUE, 'pesan'=>['msg'=>'Data berhasil disimpan']];
            }
            else {
                $response=['status'=>FALSE, 'pesan'=>['msg'=>'Data gagal disimpan']];
            }
        }
        return response()->json($response);
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $data = [
            'data'=>$this->model::find($id),
            'kim'=>Kim::pluck('nama','id'),
        ];
        return view('backend.'.$this->kode.'.ubah', $data);
    }

    public function update(Request $request, $id)
    {
        $validator=Validator::make($request->all(), [
            'password'=>'nullable|min:6', 'kim_id'=>'required', 'level_kim'=>'required',
        ]);
        if ($validator->fails()) {
            $response=['status'=>FALSE, 'pesan'=>$validator->messages()];
        }
        else {
            $kimanggota = $this->model::find($id);
            $user=User::find($kimanggota->user_id);
            if ($request->password !== null) {
                $update=$user->update($request->all());
            }
            else {
                $update=$user->update($request->except('password'));
            }
            if ($update) {
                $kimanggota->update(['level_kim'=>$request->level_kim,'kim_id'=>$request->kim_id]);
                $response=['status'=>TRUE, 'pesan'=>['msg'=>'Data berhasil diubah']];
            }
            else {
                $response=['status'=>FALSE, 'pesan'=>['msg'=>'Data gagal diubah']];
            }
        }
        return response()->json($response);
    }

    public function hapus($id)
    {
        $user=User::find($id);
        return view('backend.'.$this->kode.'.hapus', ['user'=>$user]);
    }

    public function destroy($id)
    {
        $user=User::find($id);
        if ($user->id == Auth::id()) {
            return response()->json(['status'=>FALSE, 'pesan'=>['msg'=>'Maaf, tidak bisa menghapus akun sendiri. Silahkan Hubungi Administrator..']]);
        }
        if ($user->delete()) {
            $response=['status'=>TRUE, 'pesan'=>['msg'=>'Data berhasil dihapus']];
        }
        else {
            $response=['status'=>FALSE, 'pesan'=>['msg'=>'Data gagal dihapus']];
        }
        return response()->json($response);
    }
}
