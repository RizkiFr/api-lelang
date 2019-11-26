<?php

namespace App\Http\Controllers;

use DB;
use App\Bid;
use Illuminate\Http\Request;

class BidController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(request $req)
    {
        $bid = DB::table('bids')
        ->join('barangs','bids.id_barang','=','barangs.id')
        ->join('users','barangs.user_id','=','users.id')
        ->select('bids.id as bid_id', 'bids.bid','users.name as nama_user', 'barangs.*', 'users.whatsapp')
        ->where('id_user', '=', $req->user()->id)
        ->orderByDesc('bids.bid')
        ->get();
        return $bid;
    }

    public function bid($id)
    {

        $bid = DB::table('bids')
        ->join('barangs','bids.id_barang','=','barangs.id')
        ->join('users','barangs.user_id','=','users.id')
        ->select('bids.id', 'bids.bid','users.name as nama_user', 'barangs.name as nama_barang', 'users.whatsapp')
        ->where('id_barang', '=', $id)
        ->orderByDesc('bids.bid')
        ->get();
        return $bid;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(request $req)
    {
        $bid = new Bid;
        $bid->id_user = $req->user()->id;
        $bid->id_barang = $req->id_barang;
        $bid->bid = $req->bid;
        $bid->save();

        return response()->json([
            'status' => true,
            'data' => [
                'message' => 'succesfully create bid',
            ],
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bid  $bid
     * @return \Illuminate\Http\Response
     */
    public function show(Bid $bid)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bid  $bid
     * @return \Illuminate\Http\Response
     */
    public function edit(Bid $bid)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bid  $bid
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bid $bid)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bid  $bid
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bid $bid)
    {
        //
    }
}
