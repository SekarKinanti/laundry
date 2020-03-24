<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\PelangganModel;
use Auth;

class PelangganController extends Controller
{
    public function store(Request $req)
    {
        if(Auth::user()->level=="admin"){
        $validator=Validator::make($req->all(),
        [
            'nama'=>'required',
            'alamat'=>'required',
            'telp'=>'required',
           
        ]);
        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $simpan=PelangganModel::create([
            'nama'=>$req->nama,
            'alamat'=>$req->alamat,
            'telp'=>$req->telp
        ]);
            return Response()->json(['status'=>"pelanggan berhasil ditambahkan"]);
        }else{
            return Response()->json(['status'=>"data pelanggan gagal dimasukkan, anda bukan admin"]);
        }
        
    }
    public function update($id,Request $req)
    {
        if(Auth::user()->level=="admin"){
        $validator=Validator::make($req->all(),
        [
            'nama'=>'required',
            'alamat'=>'required',
            'telp'=>'required',
           
        ]);

        if($validator->fails()){
            return Response()->json($validator->errors());
        }
        $ubah=PelangganModel::where('id_pelanggan', $id)->update([
            'nama'=>$req->nama_film,
            'alamat'=>$req->genre,
            'telp'=>$req->deskripsi
        ]);
            return Response()->json(['status'=>"data pelanggan berhasil diubah"]);
        }else{
            return Response()->json(['status'=>"gagal, anda bukan admin"]);
        }
    }
    
    public function hapus($id)
    {
        if(Auth::user()->level=="admin"){
        $hapus=PelangganModel::where('id_pelanggan',$id)->delete();
            return Response()->json(['status'=>"data pelanggan berhasil dihapus"]);
        }else{
            return Response()->json(['status'=>"gagal, anda bukan admin"]);
        }
    }

    public function tampil_pelanggan(){
        if(Auth::User()->level=="admin"){
            $dt_buku=PelangganModel::get();
            return response()->json($dt_buku);
        }else{
            return response()->json(['status'=>'anda bukan admin']);
        }
    }
}