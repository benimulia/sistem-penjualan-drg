<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cabang;
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
        $id_cabang = $user->id_cabang;

        if ($id_cabang == 0) {
            $produk = Produk::with('cabang')->latest()->get();
        }else{
            $produk = Produk::with('cabang')->latest()->where('id_cabang', $id_cabang)->get();
        }

        return view('produk.index', compact('produk'), [
            "title" => "List Produk"
        ]);

    }

    public function create()
    {
        $cabang = Cabang::all();
        return view('produk.create', compact('cabang'), [
            "title" => "Tambah Produk"
        ]);
    }

    public function edit($id)
    {
        $cabang = Cabang::all();
        $produk = Produk::find($id);
        
        return view('produk.edit', compact('produk', 'cabang'), [
            "title" => "Edit Produk"
        ]);
    }

    public function store(Request $request)
    {
        try {
            $stokString = $request->stok;
            $stokString = str_replace(array('.', ','), array('', '.'), $stokString);
            $stok = floatval($stokString);

            Produk::create([
                'id_cabang' => $request->id_cabang,
                'nama_produk' => $request->nama_produk,
                'stok' => $stok,
                'satuan' => $request->satuan,
                'harga_cash' => $request->harga_cash,
                'harga_bon' => $request->harga_bon,
                'harga_beli' => $request->harga_beli,
                'diskon' => $request->diskon,
                'created_by' => auth()->user()->name,
                'updated_by' => auth()->user()->name,
            ]);
            return redirect()->route('produk.index')->with('success', 'Berhasil menambahkan data');
        } catch (Exception $e) {
            $getmessage = $e->getMessage();
            $arraymessage = explode(" ", $getmessage);
            $message = "";
            for ($i = 5; $i <= 10; $i++){
                $message .= $arraymessage[$i] . " ";
            }
            return redirect()->route('produk.create')->with('fail', 'Gagal menambahkan data. Silahkan coba lagi. ' . $message);
        }


    }

    public function update($id, Request $request)
    {
        try {
            DB::table('produk')->where('id_produk', $id)->update([
                'id_cabang' => $request->id_cabang,
                'nama_produk' => $request->nama_produk,
                'satuan' => $request->satuan,
                'harga_cash' => $request->harga_cash,
                'harga_bon' => $request->harga_bon,
                'harga_beli' => $request->harga_beli,
                'diskon' => $request->diskon,
                'updated_at' => Carbon::now(),
                'updated_by' => auth()->user()->name,
            ]);
            return redirect()->route('produk.index')->with('success', 'Berhasil mengedit data');
        } catch (Exception $e) {
            return redirect()->back()->with('fail', 'Gagal mengedit data. Silahkan coba lagi');
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