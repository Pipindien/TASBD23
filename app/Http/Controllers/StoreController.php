<?php

namespace App\Http\Controllers;

use App\Models\Gudang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StoreController extends Controller
{
    public function index() {
        $datas = DB::table('stores')->get();

        return view('store.index')->with('datas', $datas);
    }

    public function create() {
        return view('store.create');
    }

    public function store(Request $request) {
        $request->validate([
            'id_store' => 'required',
            'nama_store' => 'required'
        ]);

        DB::table('stores')->insert([
            'id_store' => $request->id_store,
            'nama_store' => $request->nama_store
        ]);

        return redirect()->route('store.index')->with('success', 'Saved Successfully');
    }

    public function edit($id) {
        $data = DB::table('stores')->where('id_store', $id)->first();

        return view('store.edit')->with('data', $data);
    }

    public function update($id, Request $request) {
        $request->validate([
            'id_store' => 'required',
            'nama_store' => 'required'
        ]);

        DB::table('stores')
            ->where('id_store', $id)
            ->update([
                'id_store' => $request->id_store,
                'nama_store' => $request->nama_store
            ]);

        return redirect()->route('store.index')->with('success', 'Changed Successfully');
    }

    public function delete($id) {
        DB::table('stores')->where('id_store', $id)->delete();

        return redirect()->route('store.index')->with('success', 'Deleted Successfully');
    }
}
