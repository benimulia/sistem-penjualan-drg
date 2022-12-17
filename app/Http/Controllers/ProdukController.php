<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cabang;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Exception;
use Carbon\Carbon;
use App\Models\Produk;

class ProdukController extends Controller
{
    

    function __construct()
    {
        $this->middleware('permission:produk-list|produk-create|produk-edit|produk-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:produk-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:produk-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:produk-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $user = auth()->user();
        if ($user->id_cabang==1){
            $produk = Produk::with('cabang')->latest()->where('id_cabang',1)->get();
            return view('produk.index', compact('produk'), [
                "title" => "List Produk"
            ]);
        }elseif($user->id_cabang==2){
            $produk = Produk::with('cabang')->latest()->where('id_cabang',2)->get();
            return view('produk.index', compact('produk'), [
                "title" => "List Produk"
            ]);
        }elseif($user->id_cabang==3){
            $produk = Produk::with('cabang')->latest()->where('id_cabang',3)->get();
            return view('produk.index', compact('produk'), [
                "title" => "List Produk"
            ]);
        }
        else{
            $produk = Produk::with('cabang')->latest()->get();
            return view('produk.index', compact('produk'), [
                "title" => "List Produk"
            ]);
        }
        
    }

    public function create()
    {
        $cabang = Cabang::all();
        return view('produk.create' , compact('cabang'), [
            "title" => "Tambah Produk"
        ]);
    }

    public function edit($id)
    {
        $cabang = Cabang::all();
        $produk = Produk::find($id);
        //dd($cabang);
        return view('produk.edit', compact('produk','cabang'), [
            "title" => "Edit Produk"
        ]);
    }

    public function store(Request $request)
    {
            Produk::create([
                'id_cabang' => $request->id_cabang,
                'nama_produk'  => $request->nama_produk,
                'stok'  => $request->stok,
                'satuan'  => $request->satuan,
                'harga_cash'  => $request->harga_cash,
                'harga_bon'  => $request->harga_bon,
                'harga_beli'  => $request->harga_beli,
                'diskon'  => $request->diskon,
                'created_by'  => auth()->user()->name,
                'updated_by'  => auth()->user()->name,
            ]);
            return redirect()->route('produk.index')->with('success', 'Berhasil menambahkan data');
        
    }

    public function update($id, Request $request)
    {
        try {
            DB::table('produk')->where('id_produk', $id)->update([
                'id_cabang' => $request->id_cabang,
                'nama_produk'  => $request->nama_produk,
                'satuan'  => $request->satuan,
                'harga_cash'  => $request->harga_cash,
                'harga_bon'  => $request->harga_bon,
                'harga_beli'  => $request->harga_beli,
                'diskon'  => $request->diskon,
                'updated_at' => Carbon::now(),
                'updated_by'  => auth()->user()->name,
            ]);
            return redirect()->route('produk.index')->with('success', 'Berhasil mengedit data');
        } catch (Exception $e) {
            return redirect()->route('produk.edit')->with('fail', 'Gagal mengedit data. Silahkan coba lagi');
        }
    }

    public function destroy($id)
    {
        $produk = Produk::find($id);

        try {
            $produk->delete();
            return redirect()->route('produk.index')->with('success', 'Berhasil menghapus data');
        } catch (Exception $e) {
            return redirect()->route('produk.index')->with('fail', 'Gagal menghapus data. Silahkan coba lagi');
        }
    }
}
