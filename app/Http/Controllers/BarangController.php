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
        $datas = DB::table('tenant')->whereNull('deleted_at')->get();
        return view('barang.index')->with('datas', $datas);
    }

    public function create()
    {
        return view('barang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_tenant' => 'required',
            'nama_stand' => 'required',
            'harga_sewa' => 'required',
            'stock' => 'required',
            'id_lokasi' => 'required',
            'id_jenis' => 'required',
        ]);

        DB::table('tenant')->insert([
            'id_tenant' => $request->id_tenant,
            'nama_stand' => $request->nama_stand,
            'harga_sewa' => $request->harga_sewa,
            'stock' => $request->stock,
            'id_lokasi' => $request->id_lokasi,
            'id_jenis' => $request->id_jenis,
        ]);

        return redirect()->route('barang.index')->with('success', 'Saved Successfully');
    }

    public function edit($id)
    {
        $data = DB::table('tenant')->where('id_tenant', $id)->first();
        return view('barang.edit')->with('data', $data);
    }

    public function show($id)
    {
        $data = DB::table('tenant as t')
            ->join('lokasi as l', 't.id_lokasi', '=', 'l.id_lokasi')
            ->join('jenis as j', 't.id_jenis', '=', 'j.id_jenis')
            ->where('t.id_tenant', $id)
            ->select('t.*', 'l.alamat', 'j.jenis')
            ->first();

        return view('barang.show')->with('data', $data);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'id_tenant' => 'required',
            'nama_stand' => 'required',
            'harga_sewa' => 'required',
            'stock' => 'required',
            'id_lokasi' => 'required',
            'id_jenis' => 'required',
        ]);

        DB::table('tenant')
            ->where('id_tenant', $id)
            ->update([
                'id_tenant' => $request->id_tenant,
                'nama_stand' => $request->nama_stand,
                'harga_sewa' => $request->harga_sewa,
                'stock' => $request->stock,
                'id_lokasi' => $request->id_lokasi,
                'id_jenis' => $request->id_jenis,
            ]);

        return redirect()->route('barang.index')->with('success', 'Updated Successfully');
    }

    public function softDelete($id)
    {
        DB::table('tenant')->where('id_tenant', $id)->update(['deleted_at' => now()]);
        return redirect('/soft');
    }

    public function restore($id)
    {
        DB::table('tenant')->where('id_tenant', $id)->update(['deleted_at' => null]);
        return redirect('/soft');
    }

    public function hardDelete($id)
    {
        DB::table('tenant')->where('id_tenant', $id)->delete();
        return redirect()->route('softDelete')->with('success', 'Deleted Successfully');
    }

    public function softIndex()
    {
        $datas = DB::table('tenant as t')
            ->join('lokasi as l', 't.id_lokasi', '=', 'l.id_lokasi')
            ->join('jenis as j', 't.id_jenis', '=', 'j.id_jenis')
            ->whereNotNull('t.deleted_at')
            ->get();

        return view('soft.index', [
            'datas' => $datas,
        ]);
    }

    public function trashed()
    {
        $datas = DB::table('tenant as t')
            ->join('lokasi as l', 't.id_lokasi', '=', 'l.id_lokasi')
            ->join('jenis as j', 't.id_jenis', '=', 'j.id_jenis')
            ->whereNotNull('t.deleted_at')
            ->get();

        return view('soft.index', [
            'datas' => $datas,
        ]);
    }
}