<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Produk;
use App\Models\Pelanggan;
use App\Models\RekapBon;
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
        if ($user->id_cabang == 1) {
            $produk = Produk::with('cabang')->where('id_cabang', 1)->orderBy('nama_produk', 'ASC')->get();
        } elseif ($user->id_cabang == 2) {
            $produk = Produk::with('cabang')->where('id_cabang', 2)->orderBy('nama_produk', 'ASC')->get();
        } elseif ($user->id_cabang == 3) {
            $produk = Produk::with('cabang')->where('id_cabang', 3)->orderBy('nama_produk', 'ASC')->get();
        } else {
            $produk = Produk::orderBy('nama_produk', 'ASC')->get();
        }

        $pelanggan = Pelanggan::all();
        $cabang = Cabang::all();

        $date = date('Y-m-d');
        $tglhariini = $this->format_hari_tanggal($date);
        return view('penjualan.create', compact('produk', 'cabang', 'pelanggan', 'tglhariini'), [
            "title" => "Tambah Penjualan"
        ]);
    }

    public function fetch(Request $request)
    {
        $id_produk = $request->id_produk;

        $data['produk'] = Produk::where("id_produk", $id_produk)
            ->get(["harga_cash", "harga_bon", "satuan"]);

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

        try{
            $penjualan = new Penjualan();
            $penjualan->id_cabang = $request->id_cabang;
            $penjualan->tgl_penjualan = $request->tgl_penjualan;
            $penjualan->id_pelanggan = $request->id_pelanggan;
    
            $total = (int) str_replace(".", "", $request->total);
            $jml_bayar = (int) str_replace(".", "", $request->jumlah_bayar);
    
            $penjualan->total_penjualan = $total;
            $penjualan->jumlah_bayar = $jml_bayar;
            $penjualan->keterangan = $request->keterangan;
            $penjualan->created_by = auth()->user()->name;
            $penjualan->updated_by = auth()->user()->name;
    
            if ($jml_bayar < $total) {
                $penjualan->status_transaksi = "Belum Lunas";
                $penjualan->jenis_transaksi = "Bon";
            } else {
                $penjualan->status_transaksi = "Lunas";
                $penjualan->jenis_transaksi = "Cash";
            }
    
            $penjualan->save();
    
            $id_penjualan = DB::table('penjualan')->orderBy('id_penjualan', 'DESC')->select('id_penjualan')->first();
            $id_penjualan = $id_penjualan->id_penjualan;
    
            foreach ($request->id_produk as $key => $items) {
                $qtyString = $request->qty[$key];
                $qtyString = str_replace(array('.', ','), array('', '.'), $qtyString);
                $qty = floatval($qtyString);
    
                $penjualanDetail['id_produk'] = $items;
                $penjualanDetail['id_penjualan'] = $id_penjualan;
                $penjualanDetail['harga'] = $request->harga[$key];
                $penjualanDetail['subtotal'] = $request->subtotal[$key];
                $penjualanDetail['satuan'] = $request->satuan[$key];
                $penjualanDetail['qty'] = $qty;
                $penjualanDetail['created_by'] = auth()->user()->name;
                $penjualanDetail['updated_by'] = auth()->user()->name;
    
                $stokproduk = DB::table('produk')->where('id_produk', $items)->select('stok')->first();
                $stokproduk = $stokproduk->stok;
    
                $stokupdate = $stokproduk - $qty;
                $update = [
                    'stok' => $stokupdate,
                    'updated_by' => "penjualan - " . auth()->user()->name,
                ];
                PenjualanDetail::create($penjualanDetail);
                Produk::where('id_produk', $items)->update($update);
            }
    
            if ($jml_bayar < $total) {
    
                try {
                    $bon = new RekapBon();
                    $bon->id_cabang = $request->id_cabang;
                    $bon->id_pelanggan = $request->id_pelanggan;
                    $bon->id_penjualan = $id_penjualan;
                    $bon->tgl_bon = $request->tgl_penjualan;
                    $bon->total = $total - $jml_bayar;
                    $bon->jumlah_terbayar = 0;
                    $bon->status = "Belum Lunas";
                    $bon->created_by = auth()->user()->name;
                    $bon->updated_by = auth()->user()->name;
    
                    $bon->save();
                } catch (Exception $e) {
                    $getmessage = $e->getMessage();
                    $arraymessage = explode(" ", $getmessage);
                    $message = "";
                    for ($i = 5; $i <= 9; $i++) {
                        $message .= $arraymessage[$i] . " ";
                    }
                    return redirect()->route('penjualan.create')->with('fail', 'Gagal menambahkan data. Silahkan coba lagi. ' . $message);
                }
            }
    
            DB::commit();
            return redirect()->route('penjualan.index')->with('success', 'Berhasil menambahkan data penjualan');
        }catch(Exception $e){
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
            /** delete record table penjualan_detail */
            $penjualandetail = DB::table('penjualan_detail')->where('id_penjualan', $id)->get();
            foreach ($penjualandetail as $key => $id_penjualan_detail) {
                $stokproduk = DB::table('produk')->where('id_produk', $id_penjualan_detail->id_produk)->select('stok')->first();
                $stokproduk = $stokproduk->stok;

                $stokupdate = $stokproduk + $id_penjualan_detail->qty;
                $update = [
                    'stok' => $stokupdate,
                    'updated_by' => "batal jual - " . auth()->user()->name,
                ];

                Produk::where('id_produk', $id_penjualan_detail->id_produk)->update($update);
                DB::table('penjualan_detail')->where('id_penjualan_detail', $id_penjualan_detail->id_penjualan_detail)->delete();
            }

            $rekap_bon = DB::table('rekap_bon')->where('id_penjualan', $id)->get();
            foreach ($rekap_bon as $key => $id_rekap_bon) {
                DB::table('rekap_bayar_bon')->where('id_bon', $id_rekap_bon->id_bon)->delete();
            }

            /** delete record table rekap_bon */
            RekapBon::destroy($id);

            /** delete record table penjualan */
            Penjualan::destroy($id);

            DB::commit();
            return redirect()->back()->with('success', 'Berhasil menghapus data');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->with('fail', 'Gagal menghapus data. Silahkan coba lagi');
        }
    }


    function format_hari_tanggal($waktu)
    {
        $hari_array = array(
            'Minggu',
            'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
            'Sabtu'
        );
        $hr = date('w', strtotime($waktu));
        $hari = $hari_array[$hr];
        $tanggal = date('j', strtotime($waktu));
        $bulan_array = array(
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        );
        $bl = date('n', strtotime($waktu));
        $bulan = $bulan_array[$bl];
        $tahun = date('Y', strtotime($waktu));
        $jam = date('H:i:s', strtotime($waktu));

        //untuk menampilkan hari, tanggal bulan tahun jam
        //return "$hari, $tanggal $bulan $tahun $jam";

        //untuk menampilkan hari, tanggal bulan tahun
        return "$hari, $tanggal $bulan $tahun";
    }
}