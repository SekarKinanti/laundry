<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\JenisCuciModel;
use Auth;

class JenisCuciController extends Controller
{
    public function store(Request $req)
    {
        if(Auth::user()->level=="admin"){
        $validator=Validator::make($req->all(),
        [
            'nama_jenis'=>'required',
            'harga_per_kilo' => 'required'
           
        ]);
        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $simpan=JenisCuciModel::create([
            'nama_jenis'=>$req->nama_jenis,
            'harga_per_kilo' =>$req->harga_per_kilo
        ]);
            return Response()->json(['status'=>"Jenis Cuci berhasil ditambahkan"]);
        }else{
            return Response()->json(['status'=>"gagal, anda bukan admin"]);
        }
    }
    public function update($id,Request $req)
    {
        if(Auth::user()->level=="admin"){
        $validator=Validator::make($req->all(),
        [
            'nama_jenis'=>'required',
            'harga_per_kilo' => 'required'
           
        ]);

        if($validator->fails()){
            return Response()->json($validator->errors());
        }
        $ubah=JenisCuciModel::where('id_jenis_cuci', $id)->update([
            'nama_jenis'=>$req->nama_jenis,
            'harga_per_kilo' =>$req->harga_per_kilo
        ]);
            return Response()->json(['status'=>"jenis cuci berhasil diubah"]);
        }else{
            return Response()->json(['status'=>"gagal, anda bukan admin"]);
        }
    }
    
    public function hapus($id)
    {
        if(Auth::user()->level=="admin"){
        $hapus=JenisCuciModel::where('id_jenis_cuci',$id)->delete();
            return Response()->json(['status'=>"jenis cuci berhasil dihapus"]);
        }else{
            return Response()->json(['status'=>"gagal, anda bukan admin"]);
        }
    }

    public function tampil_JenisCuci(){
        if(Auth::User()->level=="admin"){
            $dt_buku=JenisCuciModel::get();
            return response()->json($dt_buku);
     }else{
             return response()->json(['status'=>'anda bukan admin']);
         }
    }
}