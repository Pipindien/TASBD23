<?php

namespace App\Http\Controllers;

use App\Models\Gudang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class GudangController extends Controller
{
    public function index()
    {
        $datas = DB::table('gudangs')->get();
        return view('gudang.index')->with('datas', $datas);
    }

    public function create()
    {
        return view('gudang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_gudang' => 'required',
            'nama_gudang' => 'required'
        ]);

        DB::table('gudangs')->insert([
            'id_gudang' => $request->id_gudang,
            'nama_gudang' => $request->nama_gudang
        ]);

        return redirect()->route('gudang.index')->with('success', 'Saved Successfully');
    }

    public function edit($id)
    {
        $data = DB::table('gudangs')->where('id_gudang', $id)->first();
        return view('gudang.edit')->with('data', $data);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'id_gudang' => 'required',
            'nama_gudang' => 'required'
        ]);
       
        DB::table('gudangs')
            ->where('id_gudang', $id)
            ->update([
                'id_gudang' => $request->id_gudang,
                'nama_gudang' => $request->nama_gudang
            ]);

        return redirect()->route('gudang.index')->with('success', 'Changed Successfully');
    }

    public function delete($id)
    {
    
        DB::table('gudangs')->where('id_gudang', $id)->delete();
    
        return redirect()->route('gudang.index')->with('success', 'Deleted Successfully');
    }
    
}