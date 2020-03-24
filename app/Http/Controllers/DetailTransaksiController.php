<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TransaksiModel;
use App\DetailTransaksiModel;
use Illuminate\Support\Facades\Validator;
use Auth;
Use DB;

class DetailTransaksiController extends Controller
{
    public function store (Request $req){
        if(Auth::user()->level=="petugas"){
            $validator= Validator::make($req->all(),
            [
                'id_transaksi' => 'required',
                'id_jenis_cuci' => 'required',
                'qty' =>'required'
            ]);
            if($validator->fails()){
                return Response()->json($validator->errors());
            }
            $subtotal=DB::table('jenis_cuci')->where('id_jenis_cuci',$req->id_jenis_cuci)->first();
            $sub=$subtotal->harga_per_kilo*$req->qty;
            $simpan = DetailTransaksiModel::create([
                'id_transaksi' => $req->id_transaksi,
                'id_jenis_cuci' => $req->id_jenis_cuci,
                'qty' => $req->qty,
                'subtotal' => $sub,
            ]);
            return Response()->json(['status'=>'data detail berhasil di tambahkan']);
        } else {
            return Response()->json(['status'=>'gagal, anda bukan petugas']);
        }
    }

    public function tampil($tgl1, $tgl2){
        $trans = DB::table('transaksi')->join('pelanggan','pelanggan.id_pelanggan','transaksi.id_pelanggan') 
        ->where('tgl_transaksi','>=',$tgl1) 
        ->where('tgl_transaksi','<=',$tgl2) 
        ->select('transaksi.id','tgl_transaksi','nama','alamat','telp','tgl_jadi') 
        ->get();

        $datatrans=array();
        $no=0;
        foreach ($trans as $t){
            $datatrans[$no]['tgl_transaksi']=$t->tgl_transaksi;
            $datatrans[$no]['nama_pelanggan']=$t->nama;
            $datatrans[$no]['alamat']=$t->alamat;
            $datatrans[$no]['telepon']=$t->telp;
            $datatrans[$no]['tgl_jadi']=$t->tgl_jadi;

        $grand=DB::table('detail_transaksi')
        ->where('id_transaksi',$t->id)->groupBy("id_transaksi")
        ->select(DB::raw('sum(subtotal)as grandtotal'))
        ->first();

        $datatrans[$no]['grandtotal']=$grand;
        $detail=DB::table('detail_transaksi')->join('jenis_cuci','jenis_cuci.id_jenis_cuci','detail_transaksi.id_jenis_cuci')
        ->where('id_transaksi',$t->id)
        ->select('nama_jenis','harga_per_kilo','qty','subtotal')
        ->get();

        $datatrans[$no]['detail']=$detail;
         $no++;}
        return Response()->json($datatrans);
    }

    public function update($id,Request $req) {
        if(Auth::user()->level=='petugas'){
            $validator=Validator::make($req->all(),
            [
            'id_transaksi' =>'required',
            'id_jenis_cuci'=>'required',
            'qty' =>'required'
            ]);
            if($validator->fails()){
                return Response()->json($validator->errors());
            }
            $subtotal=DB::table('jenis_cuci')->where('id',$req->id_jenis)->first();
            $sub=$subtotal->harga_per_kilo*$req->qty;
            $ubah=DetailTransaksiModel::where('id',$id)->update([
                'id_transaksi' =>$req->id_transaksi,
                'id_jenis_cuci' =>$req->id_jenis_cuci,
                'qty' =>$req->qty,
                'subtotal' =>$req->subtotal
            ]);
            return Response()->json(['status'=>'detail berhasil diubah']);
        } else {
            return Response()->json(['status' =>'gagal, anda bukan petugas']);
        }
    }
    
    public function delete ($id){
        if(Auth::user()->level=='admin'){
            $hapus=DetailTransaksiModel::where('id',$id)->delete();
            return Response()->json(['status'=>'detail berhasil dihapus']);
        } else{
            return Response()->json(['status'=>'gagal, anda bukan petugas']);
        }
    }
}
