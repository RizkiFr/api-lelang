<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\barang;

class BarangController extends Controller
{
    public function index()
    {
        $barang = DB::table('barangs')
        ->join('users','barangs.user_id','=','users.id')
        ->select('barangs.*', 'users.name as nama_user')
        ->where('tgl_lelang', '=', date("Y-m-d", time()))
        ->get();
        return $barang;
    }

    public function mybarang(request $req)
    {
        $barang = DB::table('barangs')
        ->join('users','barangs.user_id','=','users.id')
        ->select('barangs.*', 'users.name as nama_user')
        ->where('barangs.user_id', '=', $req->user()->id)
        ->get();
        return $barang;
    }

    public function coming()
    {
        $barang = DB::table('barangs')
        ->where('tgl_lelang', '>', date("Y-m-d", time()))
        ->get();
        return $barang;
    }

    public function create(request $req)
    {
        $barang = new barang;
        $barang->name = $req->name;
        $barang->desc = $req->desc;
        $barang->harga = $req->harga;
        $barang->tgl_lelang = $req->tgl_lelang;
        $barang->waktu_lelang = $req->waktu_lelang;
        $barang->durasi = $req->durasi;
        $barang->user_id = $req->user()->id;
        // $barang->save();

        $image = $req->file('url');
        if (empty($image)) {
            $image = null;
        } else {
            $fileName = time().'.'.$image->getClientOriginalExtension();;
            $req->file('url')->move('images/', $fileName);
        }
        $host = request()->getHttpHost();
        $barang->url = $host.'/'.'images/'.$fileName;
        $barang->save();

        return response()->json([
            'status' => true,
            'data' => [
                'message' => 'succesfully create chapter',
            ],
        ], 200);
    }

    public function delete($id)
    {
        $barangs = barang::find($id);
        $barangs->delete();
        return 'Berhasil delet';
    }
}
