<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class KeteranganController extends Controller
{
    public function index()
    {
        $datas = DB::table('barangs as b')
            ->join('gudangs as g', 'b.id_gudang', '=', 'g.id_gudang')
            ->join('stores as s', 'b.id_store', '=', 's.id_store')
            ->select('b.*', 'g.nama_gudang', 's.nama_store')
            ->get();
    
        return view('keterangan.index', [
            'datas' => $datas
        ]);
    }
}