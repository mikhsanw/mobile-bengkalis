<?php

namespace App\Http\Controllers\api;

use App\Model\foto;
use App\Helpers\Help;
use App\Model\Berita;
use App\Model\Product;
use App\Model\KegiatanKim;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class KimController extends Controller
{
    public function dashboard(Request $request){
        $keg = KegiatanKim::with('kim','file')->take(10)->get();
        foreach ($keg as $key => $value) {
            $item=[];
            $item['nama']=$value->nama;
            $item['lokasi']=$value->lokasi;
            $item['tanggal']=Help::displayDateTime($value->tanggal);
            $item['jenis']=config('master.level_kegiatan_kim.'.$value->jenis);
            $item['deskripsi']=$value->deskripsi;
            $item['nama_kim']=$value->kim->nama;
            foreach($value->file as $key => $img){
                $item['file'][$key]=$img->url_stream;
            }
            
            $kegiatan[]=$item;
        }

        $prods = Product::with('kim')->take(10)->get();
        foreach ($prods as $key => $prod) {
            $item=[];
            $item['nama']=$prod->nama;
            $item['harga']=Help::currency($prod->harga);
            $item['jenis']=config('master.product.'.$prod->jenis);
            $item['deskripsi']=$prod->deskripsi;
            $item['nama_kim']=$prod->kim->nama;
            foreach($prod->file as $key => $img){
                $item['file'][$key]=$img->url_stream;
            }
            
            $products[]=$item;
        }

        //berita
        $beritas = Berita::limit(10)->get();
        $databerita = $beritas->map(function($berita) {
            return [
                'id' => $berita->id,
                'nama' => $berita->nama,
                'isi' => $berita->isi,
                'tanggal' => Help::shortDateTime($berita->tanggal),
                'view' => $berita->view,
                'foto' => $berita->file->url_stream,
            ];
        });
        
        //slider
        $slides[]['file']=asset('KIM.png');
        $slide = foto::limit(10)->get();
        foreach($slide as $val){
            $item=[];
            $item['file']=$val->file->url_stream;
            $slides[]= $item; 
        };

        $data = [
            'menu' => [
                [
                'id'=>1,
                'nama'=>'Kegiatan',
                'link'=>'formkegiatan',
                'color'=>'primary',
                'icon'=>'people-outline'
                ],
                [
                'id'=>2,
                'nama'=>'Pembangunan',
                'link'=>'formkegiatan',
                'color'=>'danger',
                'icon'=>'business-outline'
                ],
                [
                'id'=>3,
                'nama'=>'Produk',
                'link'=>'formproduct',
                'color'=>'warning',
                'icon'=>'bag-handle-outline'
                ]
            ],
            'kegiatan' => $kegiatan??[],
            'produk' => $products??[],
            'berita' => $databerita??[],
            'slider' => $slides??[]
        ];
        return response()->json([
            "status"=>true,
            "message"=>"Data ditemukan",
            "data"=>$data
        ]);
    }
    public function login(Request $request)
    {
        $credentials=$request->only('email', 'password');
        $cekuser = \App\Model\User::where(['email'=>$request->email,'level'=>2])->first();
        if(!$cekuser){
            return response()->json(['status'=>false,'pesan'=>'Email tidak terdaftar']);
        }
        elseif(!Hash::check($request->password, $cekuser->password)){
            return response()->json(['status'=>false,'pesan'=>'Password salah']);
        }

        if (auth()->attempt($credentials)) {
            $user=auth()->user();
            $token=$user->createToken(uniqid().now())->plainTextToken;
            $response=[
                'status'=>true,
                'message'=>'Login berhasil',
                'data'=>[
                    'user'=>$user,
                    'token'=>$token,
                ],
            ];
        }
        return response()->json($response);
    }
    public function getkimkegiatan(Request $request)
    {
        $page = ($request->page ?? 1)-1;
        $limit = 5;
        $offset = $page * $limit;
        $keg = KegiatanKim::with('kim')->where('nama','LIKE','%'.$request->cari.'%')->latest()->offset($offset)->limit($limit)->get();
        foreach ($keg as $key => $value) {
            $item=[];
            $item['nama']=$value->nama;
            $item['lokasi']=$value->lokasi;
            $item['tanggal']=Help::shortDateTime($value->tanggal);
            $item['jenis']=config('master.level_kegiatan_kim.'.$value->jenis);
            $item['deskripsi']=$value->deskripsi;
            $item['nama_kim']=$value->kim->nama;
            foreach($value->file as $key => $img){
                $item['file'][$key]=$img->url_stream;
            }
            
            $datas[]=$item;
        }
        return response()->json([
            "status"=>true,
            "message"=>"Data ditemukan",
            "data"=>$datas
        ]);
    }
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(), [
                'nama' => 'required|'.config('master.regex.json'),
                'file' => 'required',
                'tanggal' => 'required',
                'lokasi' => 'required|'.config('master.regex.json'),
                'jenis' => 'required|'.config('master.regex.json'),
                'deskripsi' => 'required|'.config('master.regex.json'),
            ]);
        if ($validator->fails()) {
            $respon=['status'=>false, 'pesan'=>$validator->messages()];
        }
        else {
            $request->request->add(['kim_id'=>$request->user()->kim_anggota->kim_id]);
            $request->request->add(['kim_anggota_id'=>$request->user()->kim_anggota->id]);
            
            $data = KegiatanKim::create($request->all());
            foreach($request->file as $key => $item){
                $image_64 = $item; //your base64 encoded data
                $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];
                $replace = substr($image_64, 0, strpos($image_64, ',')+1);
                $image = str_replace($replace, '', $image_64);
                $image = str_replace(' ', '+', $image);
                $image = base64_decode($image);
                $imageName = 'permohonan/file/'.date('Y').'/'.date('m').'/'.date('d').'/'.uniqid().'.'.$extension;
                if(Storage::put($imageName,$image)){
                    $data->file()->create([
                        'name'                  => $key,
                        'data'                      =>  [
                            'disk'      => config('filesystems.default'),
                            'target'    => $imageName,
                        ]
                    ]);
                };
            }
            $respon=["status"=>true,"message"=>"Data ditemukan", 'pesan'=>'Data berhasil disimpan'];
        }
        return $respon;
    }

    public function getJenisProduk(){
        $jenis = config('master.jenis_product');
        return response()->json($jenis,200);
    }
    
    public function getproduct(Request $request)
    {
        $page = ($request->page ?? 1)-1;
        $limit = 5;
        $offset = $page * $limit;
        $prod = Product::with('kim')->where('nama','LIKE','%'.$request->cari.'%')->latest()->offset($offset)->limit($limit)->get();
        foreach ($prod as $key => $value) {
            $item=[];
            $item['nama']=$value->nama;
            $item['harga']=Help::currency($value->harga);
            $item['jenis']=config('master.product.'.$value->jenis);
            $item['deskripsi']=$value->deskripsi;
            $item['nama_kim']=$value->kim->nama;
            foreach($value->file as $key => $img){
                $item['file'][$key]=$img->url_stream;
            }
            
            $datas[]=$item;
        }
        return response()->json([
            "status"=>true,
            "message"=>"Data ditemukan",
            "data"=>$datas
        ]);
    }

    public function storeproduct(Request $request)
    {
        $validator=Validator::make($request->all(), [
                'nama' => 'required|'.config('master.regex.json'),
                'harga' => 'required|'.config('master.regex.number'),
                'jenis' => 'required|'.config('master.regex.json'),
                'deskripsi' => 'required|'.config('master.regex.json'),
                'file' => 'required',
            ]);
        if ($validator->fails()) {
            $respon=['status'=>false, 'pesan'=>$validator->messages()];
        }
        else {
            $request->request->add(['kim_id'=>$request->user()->kim_anggota->kim_id]);
            $request->request->add(['kim_anggota_id'=>$request->user()->kim_anggota->id]);
            
            $data = Product::create($request->all());
            foreach($request->file as $key => $item){
                $image_64 = $item; //your base64 encoded data
                $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];
                $replace = substr($image_64, 0, strpos($image_64, ',')+1);
                $image = str_replace($replace, '', $image_64);
                $image = str_replace(' ', '+', $image);
                $image = base64_decode($image);
                $imageName = 'permohonan/file/'.date('Y').'/'.date('m').'/'.date('d').'/'.uniqid().'.'.$extension;
                if(Storage::put($imageName,$image)){
                    $data->file()->create([
                        'name'                  => $key,
                        'data'                      =>  [
                            'disk'      => config('filesystems.default'),
                            'target'    => $imageName,
                        ]
                    ]);
                };
            }
            $respon=["status"=>true,"message"=>"Data ditemukan", 'pesan'=>'Data berhasil disimpan'];
        }
        return $respon;
    }
    
    public function berita(request $req)
    {
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
        return response()->json(['status'=>true,'data' => $data], 200);
    }

    public function tentang(Request $request){
        $data = "
                <p><strong>AZAS PEMBENTUKAN.</strong>
                KIM dibentuk berasaskan Pancasila, dengan prinsip transparan dan demokratis yang bercirikan kebersamaan, kebermaknaan, kemandirian, kegotong-royongan dan persamaan hak dan kewajiban.  Dari anggota, oleh anggota dan untuk anggota.</p>

                <p><strong>MAKSUD DAN TUJUAN.</strong>

                KIM dibentuk dengan maksud untuk meningkatkan pengetahuan, kecerdasan, keterampilan, kearifan yang mendorong berkembangnya motivasi masyarakat dalam berparitipasi aktif dalam penyelenggaraan pemerintahan dan pembangunan.</p>

                <strong>Tujuan KIM adalah :</strong>
                <ul>
                    <li>Sebagai mitra pemerintah dalam penyebarluasan, sosialisasi dan desiminasi informasi pembangunan kepada masyarakat ;</li>
                    <li>Sebagai mediator komunikasi dan informasi pemerintahan dan pembangunan secara timbal balik dan berkesinambungan ;</li>
                    <li>Sebagai forum media untuk pelayanan komunikasi dan informasi pemerintahan dan pembangunan.</li>
                </ul>
                <span style='text-decoration: underline;'><strong> </strong><strong> </strong><strong>FUNGSI, TUGAS DAN PERAN.</strong></span>
                <br/>
                <strong>Fungsi :</strong>
                <ul>
                    <li>sebagai wahana untuk penerimaan, pengelolaan  dan penyebaran informasi pemerintahan dan pembangunan kepada masyarakat ;</li>
                    <li>sebagai wahana interaksi dan berkomunikasi antar masyarakat/anggota KIM, antara masyarakat/anggota KIM dengan pemerintah ;</li>
                    <li>Sebagai peningkatan <em>media literacy </em>dilingkungan anggota ;</li>
                    <li>Sebagai lembaga swadaya masyarakat yang memiliki dampak dan nilai ekonomis melalui pengelolaan informasi ;</li>
                    <li>Sebagai ajang silaturahmi antar anggota masyarakat dan antara masyarakat dan pemerintah untuk memperkokoh kebersamaan,  persatuan dan kesatuan.</li>
                </ul>
                <strong>Tugas :</strong>
                <ul>
                    <li>Mewujudkan masyarakat yang dinamis, peduli dan peka terhadap arus informasi ;</li>
                    <li>Memberdayakan masyarakat agar memiliki kecerdasan dalam mencerna, memilih dan  memilah informasi yang menjadi kebutuhannya untuk meningkatkan kesejahteraan hidupnya ;</li>
                    <li>Menjadikan KIM sebagai katalisator dan dinamisator dalam memelihara dan meningkatkan semangat kegotongroyongan dan  kebersamaan dalam masyarakat.</li>
                </ul>
                <strong>Peran :</strong>
                <ul>
                    <li><em>Memanage Informasi</em>, yaitu mencari, mengumpulkan, mengelola dan mendesiminasikan informasi kepada masyarakat sesuai dengan kebutuhannya ;</li>
                    <li><em>Mediasi Informasi</em>, yaitu menjembatani arus informasi antar anggota masyarakat, antara masyarakat dengan pemerintah ;</li>
                    <li><em>Mengedukasi Insan Informasi, </em>yaitu meningkatkan sumber daya masyarakat di bidang informasi, agar memiliki kecerdasan dalam menerima terpaan arus informasi ;</li>
                </ul>
                <strong>KEDUDUKAN.</strong>

                KIM berkedudukan di tingkat desa dan kelurahan  secara mandiri dan non partisan sebagai wujud partisipasi masyarakat dalam pembangunan di bidang komunikasi dan informasi.

                Pada tingkat Dusun, RW atau komunitas kecil lainnya dapat dibentuk  kelompok-kelompok desiminanasi yang merupakan bagian yang tak terpisahkan dari kegiatan KIM Desa atau Kelurahan.
                ";
        return response()->json([
            "status"=>true,
            "message"=>"Data ditemukan",
            "data"=>$data
        ]);
    }
}
