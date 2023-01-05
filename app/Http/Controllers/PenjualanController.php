<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Produk;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cabang;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Exception;
use Carbon\Carbon;
use App\Models\PenjualanDetail;

class PenjualanController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:penjualan-list|penjualan-create|penjualan-edit|penjualan-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:penjualan-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:penjualan-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:penjualan-delete', ['only' => ['destroy']]);
    }


    public function produkCabang($cabang)
    {
        return Produk::where('id_cabang', $cabang)->get();
    }

    public function index()
    {
        $user = auth()->user();
        if ($user->id_cabang == 1) {
            $penjualan = Penjualan::with('cabang')->latest()->where('id_cabang', 1)->get();
            return view('penjualan.index', compact('penjualan'), [
                "title" => "List Penjualan"
            ]);
        } elseif ($user->id_cabang == 2) {
            $penjualan = Penjualan::with('cabang')->latest()->where('id_cabang', 2)->get();
            return view('penjualan.index', compact('penjualan'), [
                "title" => "List Penjualan"
            ]);
        } elseif ($user->id_cabang == 3) {
            $penjualan = Penjualan::with('cabang')->latest()->where('id_cabang', 3)->get();
            return view('penjualan.index', compact('penjualan'), [
                "title" => "List Penjualan"
            ]);
        } else {
            $penjualan = Penjualan::with('cabang')->latest()->get();
            return view('penjualan.index', compact('penjualan'), [
                "title" => "List Penjualan"
            ]);
        }
    }

    public function create()
    {
        $user = auth()->user();
        if ($user->id_cabang==1) {
            $produk = Produk::with('cabang')->where('id_cabang', 1)->orderBy('nama_produk', 'ASC')->get();
        } elseif ($user->id_cabang==2) {
            $produk = Produk::with('cabang')->where('id_cabang', 2)->orderBy('nama_produk', 'ASC')->get();
        } elseif ($user->id_cabang==3) {
            $produk = Produk::with('cabang')->where('id_cabang', 3)->orderBy('nama_produk', 'ASC')->get();
        } else {
            $produk = Produk::orderBy('nama_produk', 'ASC')->get();
        }

        $pelanggan = Pelanggan::all();
        $cabang = Cabang::all();
        return view('penjualan.create', compact('produk', 'cabang', 'pelanggan' ), [
            "title" => "Tambah Penjualan"
        ]);
    }

    public function fetch(Request $request)
    {
        $id_produk = $request->id_produk;

        $data['produk'] = Produk::where("id_produk", $id_produk)
                                ->get(["harga_cash", "harga_bon"]);

        return response()->json($data);
    }

    public function edit($id)
    {
        $produk = Produk::all();
        $cabang = Cabang::all();

        $pembelian = DB::table('pembelian')->where('id_pembelian', $id)->first();
        $pembelianJoin = DB::table('pembelian')
            ->join('pembelian_detail', 'pembelian.id_pembelian', '=', 'pembelian_detail.id_pembelian')
            ->select('pembelian.*', 'pembelian_detail.*')
            ->where('pembelian_detail.id_pembelian', $id)
            ->get();
        return view('pembelian.edit', compact('pembelian', 'pembelianJoin', 'cabang', 'produk'), [
            "title" => "Edit Data Penjualan"
        ]);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $penjualan = new Penjualan();
            $penjualan->id_cabang = $request->id_cabang;
            $penjualan->tgl_penjualan = $request->tgl_penjualan;
            $penjualan->id_pelanggan = $request->id_pelanggan;
            $penjualan->jenis_transaksi = $request->jenis_transaksi;
            $penjualan->total_penjualan = str_replace(".", "", $request->total);
            $penjualan->keterangan = $request->keterangan;
            $penjualan->created_by = auth()->user()->name;
            $penjualan->updated_by = auth()->user()->name;
            $penjualan->save();

            $id_penjualan = DB::table('penjualan')->orderBy('id_penjualan', 'DESC')->select('id_penjualan')->first();
            $id_penjualan = $id_penjualan->id_penjualan;

            foreach ($request->id_produk as $key => $items) {
                $penjualanDetail['id_produk'] = $items;
                $penjualanDetail['id_penjualan'] = $id_penjualan;
                $penjualanDetail['harga'] = $request->harga[$key];
                $penjualanDetail['subtotal'] = $request->subtotal[$key];
                $penjualanDetail['qty'] = $request->qty[$key];
                $penjualanDetail['created_by'] = auth()->user()->name;
                $penjualanDetail['updated_by'] = auth()->user()->name;

                $stokproduk = DB::table('produk')->where('id_produk', $items)->select('stok')->first();
                $stokproduk = $stokproduk->stok;

                $stokupdate = $stokproduk + $request->qty[$key];
                $update = [
                    'stok' => $stokupdate,
                    'updated_by' => "penjualan - " . auth()->user()->name,
                ];
                PenjualanDetail::create($penjualanDetail);
                Produk::where('id_produk', $items)->update($update);
            }

            DB::commit();
            return redirect()->route('penjualan.index')->with('success', 'Berhasil menambahkan data penjualan');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('fail', 'Gagal menambahkan data penjualan');
        }
    }
// ======================== belum
    public function update($id, Request $request)
    {
        try {
            DB::table('produk')->where('id_produk', $id)->update([
                'id_cabang' => $request->id_cabang,
                'nama_produk' => $request->nama_produk,
                'satuan' => $request->satuan,
                'harga_cash' => $request->harga_cash,
                'harga_bon' => $request->harga_bon,
                'diskon' => $request->diskon,
                'keterangan' => $request->keterangan,
                'updated_at' => Carbon::now(),
                'updated_by' => auth()->user()->name,
            ]);
            return redirect()->route('produk.index')->with('success', 'Berhasil mengedit data');
        } catch (Exception $e) {
            return redirect()->route('produk.edit')->with('fail', 'Gagal mengedit data. Silahkan coba lagi');
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            /** delete record table pembelian_detail */
            $pembeliandetail = DB::table('pembelian_detail')->where('id_pembelian', $id)->get();
            foreach ($pembeliandetail as $key => $id_pembelian_detail) {
                $stokproduk = DB::table('produk')->where('id_produk', $id_pembelian_detail->id_produk)->select('stok')->first();
                $stokproduk = $stokproduk->stok;

                $stokupdate = $stokproduk - $id_pembelian_detail->qty;
                $update = [
                    'stok' => $stokupdate,
                    'updated_by' => "pengurangan - " . auth()->user()->name,
                ];

                Produk::where('id_produk', $id_pembelian_detail->id_produk)->update($update);
                DB::table('pembelian_detail')->where('id_pembelian_detail', $id_pembelian_detail->id_pembelian_detail)->delete();
            }

            /** delete record table pembelian */
            Penjualan::destroy($id);

            DB::commit();
            return redirect()->back()->with('success', 'Berhasil menghapus data');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->with('fail', 'Gagal menghapus data. Silahkan coba lagi');
        }
    }
}
