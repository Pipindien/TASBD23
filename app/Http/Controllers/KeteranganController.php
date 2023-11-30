<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class KeteranganController extends Controller
{
    public function index()
    {
        $datas = DB::table('tenant as t')
            ->join('lokasi as l', 't.id_lokasi', '=', 'l.id_lokasi')
            ->join('jenis as j', 't.id_jenis', '=', 'j.id_jenis')
            ->select('t.*', 'l.alamat', 'j.jenis')
            ->get();
    
        return view('keterangan.index', [
            'datas' => $datas
        ]);
    }
}