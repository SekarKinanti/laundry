<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PelangganModel;
use App\PetugasModel;
use App\TransaksiModel;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;

class TransaksiController extends Controller
{
    public function store(Request $req){
        if(Auth::user()->level=="petugas"){
            $validator = Validator::make($req->all(),
            [
                'id_pelanggan' => 'required',
                'id_petugas' => 'required',
                'tgl_transaksi' => 'required',
                'tgl_jadi' => 'required'
            ]);
            if($validator->fails()){
                return Response()->json($validator->errors());
            }
            $simpan = TransaksiModel::create([
                'id_pelanggan' => $req->id_pelanggan,
                'id_petugas' => $req->id_petugas,
                'tgl_transaksi' => $req->tgl_transaksi,
                'tgl_jadi' => $req->tgl_jadi
            ]);
            return Response()->json(['status'=>'Data Transaksi berhasil ditambahkan']);
        } else {
            return Response()->json(['status'=>'gagal, anda bukan petugas']);
        }
    }

    public function tampil(){
        if(Auth::user()->level=="petugas"){
            $datas = TransaksiModel::get();
            $count = $datas->count();
            $anggota = array();
            $status =1;
            foreach ($datas as $dt_sw){
                $anggota[] = array(
                    'id' => $dt_sw->id,
                    'id_pelanggan' => $dt_sw->id_pelanggan,
                    'id_petugas' => $dt_sw->id_petugas,    
                    'tgl_transaksi' => $dt_sw->tgl_transaksi,
                    'tgl_jadi' => $dt_sw->tgl_jadi,
                    'created_at' => $dt_sw->created_at,
                    'updated_at' => $dt_sw->updated_at
                );
            }
            return Response()->json(compact('count','anggota'));
        } else{
            return Response()->json(['status'=>'gagal, anda bukan petugas']);
        }
    }

    public function update($id,Request $req){
        if(Auth::user()->level=="petugas"){
            $validator=Validator::make($req->all(),
            [
                'id_pelanggan' => 'required',
                'id_petugas' => 'required',
                'tgl_transaksi' => 'required',
                'tgl_jadi' => 'required'
            ]);
            if($validator->fails()){
                return Response()->json($validator->errors());
            }
            $ubah=TransaksiModel::where('id',$id)->update([
                'id_pelanggan' => $req->id_pelanggan,
                'id_petugas' => $req->id_petugas,
                'tgl_transaksi' => $req->tgl_transaksi,
                'tgl_jadi' => $req->tgl_jadi
            ]);
            return Response()->json(['status'=>'transaksi berhasil diubah']);
        } else {
            return Response()->json(['status'=>'gagal, anda bukan petugas']);
        }
    }

    public function delete($id){
        if(Auth::user()->level=="petugas"){
            $hapus=TransaksiModel::where('id',$id)->delete();
            return Response()->json(['status'=>'transaksi berhasil dihapus']);
        }else{
            return Response()->json(['status'=>'gagal, anda bukan petugas']);
        }
    }

    public function deletedetail($id){
        if(Auth::user()->level=="petugas"){
            $hapus=TransaksiModel::where('id',$id)->delete();
            return Response()->json(['status'=>'detail berhasil dihapus']);
        }else{
            return Response()->json(['status'=>'gagal, anda bukan petugas']);
        }
    }
}
