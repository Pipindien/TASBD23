<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BarangController extends Controller
{
    public function index()
    {
        $datas = DB::table('barangs')->whereNull('deleted_at')->get();
        return view('barang.index')->with('datas', $datas);
    }

    public function create()
    {
        return view('barang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_barang' => 'required',
            'nama_barang' => 'required',
            'harga' => 'required',
            'stock' => 'required',
            'id_gudang' => 'required',
            'id_store' => 'required',
        ]);

        DB::table('barangs')->insert([
            'id_barang' => $request->id_barang,
            'nama_barang' => $request->nama_barang,
            'harga' => $request->harga,
            'stock' => $request->stock,
            'id_gudang' => $request->id_gudang,
            'id_store' => $request->id_store,
        ]);

        return redirect()->route('barang.index')->with('success', 'Saved Successfully');
    }

    public function edit($id)
    {
        $data = DB::table('barangs')->where('id_barang', $id)->first();
        return view('barang.edit')->with('data', $data);
    }

    public function show($id)
    {
        $data = DB::table('barangs as b')
            ->join('gudangs as g', 'b.id_gudang', '=', 'g.id_gudang')
            ->join('stores as s', 'b.id_store', '=', 's.id_store')
            ->where('b.id_barang', $id)
            ->select('b.*', 'g.nama_gudang', 's.nama_store')
            ->first();

        return view('barang.show')->with('data', $data);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'id_barang' => 'required',
            'nama_barang' => 'required',
            'harga' => 'required',
            'stock' => 'required',
            'id_gudang' => 'required',
            'id_store' => 'required',
        ]);

        DB::table('barangs')
            ->where('id_barang', $id)
            ->update([
                'id_barang' => $request->id_barang,
                'nama_barang' => $request->nama_barang,
                'harga' => $request->harga,
                'stock' => $request->stock,
                'id_gudang' => $request->id_gudang,
                'id_store' => $request->id_store,
            ]);

        return redirect()->route('barang.index')->with('success', 'Updated Successfully');
    }

    public function softDelete($id)
    {
        DB::table('barangs')->where('id_barang', $id)->update(['deleted_at' => now()]);
        return redirect('/soft');
    }

    public function restore($id)
    {
        DB::table('barangs')->where('id_barang', $id)->update(['deleted_at' => null]);
        return redirect('/soft');
    }

    public function hardDelete($id)
    {
        DB::table('barangs')->where('id_barang', $id)->delete();
        return redirect()->route('softDelete')->with('success', 'Deleted Successfully');
    }

    public function softIndex()
    {
        $datas = DB::table('barangs as b')
            ->join('gudangs as g', 'b.id_gudang', '=', 'g.id_gudang')
            ->join('stores as s', 'b.id_store', '=', 's.id_store')
            ->whereNotNull('b.deleted_at')
            ->get();

        return view('soft.index', [
            'datas' => $datas,
        ]);
    }

    public function trashed()
    {
        $datas = DB::table('barangs as b')
            ->join('gudangs as g', 'b.id_gudang', '=', 'g.id_gudang')
            ->join('stores as s', 'b.id_store', '=', 's.id_store')
            ->whereNotNull('b.deleted_at')
            ->get();

        return view('soft.index', [
            'datas' => $datas,
        ]);
    }
}