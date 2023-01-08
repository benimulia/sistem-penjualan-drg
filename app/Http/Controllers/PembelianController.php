<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cabang;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Exception;
use Carbon\Carbon;
use App\Models\Pembelian;
use App\Models\PembelianDetail;

class PembelianController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:pembelian-list|pembelian-create|pembelian-edit|pembelian-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:pembelian-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:pembelian-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:pembelian-delete', ['only' => ['destroy']]);
    }


    public function produkCabang($cabang){
        return Produk::where('id_cabang',$cabang)->get();
    }
    
    public function index()
    {
        $user = auth()->user();
        $id_cabang = $user->id_cabang;

        if ($id_cabang == 0) {
            $pembelian = Pembelian::with('cabang')->latest()->get();
        }else{
            $pembelian = Pembelian::with('cabang')->latest()->where('id_cabang', $id_cabang)->get();
        }

        return view('pembelian.index', compact('pembelian'), [
            "title" => "List Pembelian"
        ]);

    }

    public function create()
    {
        $user = auth()->user();
        $id_cabang = $user->id_cabang;

        if ($id_cabang == 0) {
            $produk = Produk::orderBy('nama_produk','ASC')->get();
        }else{
            $produk = Produk::with('cabang')->where('id_cabang',$id_cabang)->orderBy('nama_produk','ASC')->get();
        }

        $cabang = Cabang::all();
        return view('pembelian.create', compact('produk', 'cabang'), [
            "title" => "Tambah Pembelian"
        ]);
    }

    public function edit($id)
    {
        $produk = Produk::all();
        $cabang = Cabang::all();

        $pembelian = Pembelian::with('cabang')->where('id_pembelian', $id)->first();
        $pembelianJoin = DB::table('pembelian')
            ->join('pembelian_detail', 'pembelian.id_pembelian', '=', 'pembelian_detail.id_pembelian')
            ->select('pembelian.*', 'pembelian_detail.*')
            ->where('pembelian_detail.id_pembelian', $id)
            ->get();
        return view('pembelian.edit', compact('pembelian', 'pembelianJoin', 'produk'), [
            "title" => "Edit Data Pembelian"
        ]);
    }

    public function store(Request $request)
    {

        DB::beginTransaction();

        try {
        $pembelian = new Pembelian;
        $pembelian->id_cabang = $request->id_cabang;
        $pembelian->tgl_pembelian = $request->tgl_pembelian;
        $pembelian->supplier = $request->supplier;
        $pembelian->total_pembelian = str_replace(".", "", $request->total);
        $pembelian->keterangan = $request->keterangan;
        $pembelian->created_by = auth()->user()->name;
        $pembelian->updated_by = auth()->user()->name;
        $pembelian->save();

        $id_pembelian = DB::table('pembelian')->orderBy('id_pembelian', 'DESC')->select('id_pembelian')->first();
        $id_pembelian = $id_pembelian->id_pembelian;

        foreach ($request->id_produk as $key => $items) {
            $qtyString = $request->qty[$key];
            $qtyString = str_replace(array('.', ','), array('', '.'), $qtyString);
            $qty = floatval($qtyString);

            $pembelianDetail['id_produk'] = $items;
            $pembelianDetail['id_pembelian'] = $id_pembelian;
            $pembelianDetail['harga'] = $request->harga[$key];
            $pembelianDetail['subtotal'] = $request->subtotal[$key];
            $pembelianDetail['qty'] = $qty;
            $pembelianDetail['created_by'] = auth()->user()->name;
            $pembelianDetail['updated_by'] = auth()->user()->name;

            $stokproduk = DB::table('produk')->where('id_produk', $items)->select('stok')->first();
            $stokproduk = $stokproduk->stok;

            $stokupdate = $stokproduk + $qty;
            $update = [
                'stok' => $stokupdate,
                'harga_beli' => $request->harga[$key],
                'updated_by' => "pembelian - " . auth()->user()->name,
            ];
            PembelianDetail::create($pembelianDetail);
            Produk::where('id_produk', $items)->update($update);

        }

        DB::commit();
        return redirect()->route('pembelian.index')->with('success', 'Berhasil menambahkan data pembelian');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('fail', 'Gagal menambahkan data pembelian');
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
            foreach ($pembeliandetail as $id_pembelian_detail) {
                $stokproduk = DB::table('produk')->where('id_produk', $id_pembelian_detail->id_produk)->select('stok')->first();
                $stokproduk = $stokproduk->stok;

                $stokupdate = $stokproduk - $id_pembelian_detail->qty;
                $update = [
                    'stok' => $stokupdate,
                    'updated_by' => "batal beli - " . auth()->user()->name,
                ];

                Produk::where('id_produk', $id_pembelian_detail->id_produk)->update($update);
                DB::table('pembelian_detail')->where('id_pembelian_detail', $id_pembelian_detail->id_pembelian_detail)->delete();
            }

            /** delete record table pembelian */
            Pembelian::destroy($id);

            DB::commit();
            return redirect()->back()->with('success', 'Berhasil menghapus data');

        } catch (Exception $e) {
            DB::rollback();
            return redirect()->with('fail', 'Gagal menghapus data. Silahkan coba lagi');
        }

    }
}