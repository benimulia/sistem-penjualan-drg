<?php

namespace App\Http\Controllers;
use App\Models\Penjualan;
use App\Models\RekapBayarBon;
use Carbon\Carbon;
use Exception;
use App\Models\Cabang;
use App\Models\Pelanggan;
use App\Models\RekapBon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RekapBonController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:rekapbon-list|rekapbon-create|rekapbon-edit|rekapbon-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:rekapbon-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:rekapbon-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:rekapbon-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $user = auth()->user();
        $id_cabang = $user->id_cabang;

        if ($id_cabang == 0) {
            $rekapbon = RekapBon::with('cabang','pelanggan')->latest()->get();
        }else{
            $rekapbon = RekapBon::with('cabang','pelanggan')->latest()->where('id_cabang', $id_cabang)->get();
        }

        return view('rekapbon.index', compact('rekapbon'), [
            "title" => "List Rekap Bon"
        ]);

    }

    public function create()
    {
        $cabang = Cabang::all();
        $pelanggan = Pelanggan::orderBy('nama_pelanggan', 'ASC')->get();
        return view('rekapbon.create', compact('cabang','pelanggan'), [
            "title" => "Tambah Rekap Bon"
        ]);
    }

    public function edit($id)
    {
        $rekapbon = RekapBon::with('penjualan')->find($id);
        $cabang = Cabang::all();
        $pelanggan = Pelanggan::orderBy('nama_pelanggan', 'ASC')->get();
        $rekapbayarbon = RekapBayarBon::where('id_bon', $id)->orderBy('tgl_bayar','ASC')->get();

        return view('rekapbon.edit', compact('rekapbon', 'cabang','pelanggan','rekapbayarbon'), [
            "title" => "Lihat Rekap Bon"
        ]);
    }

    public function store(Request $request)
    {
        try {

            $total = (int) str_replace(".", "", $request->total);
            $jml_bayar = (int) str_replace(".", "", $request->jumlah_terbayar);

            $status = "";

            if ($jml_bayar < $total) {
                $status = "Belum Lunas";
            } else {
                $status = "Lunas";
            }

            RekapBon::create([
                'id_cabang' => $request->id_cabang,
                'id_pelanggan' => $request->id_pelanggan,
                'tgl_bon' => $request->tgl_bon,
                'total' => $total,
                'jumlah_terbayar' => $jml_bayar,
                'status' => $status,
                'keterangan' => $request->keterangan,
                'created_by' => auth()->user()->name,
                'updated_by' => auth()->user()->name,
            ]);
            return redirect()->route('rekapbon.index')->with('success', 'Berhasil menambahkan data');
        } catch (Exception $e) {
            $getmessage = $e->getMessage();
            $arraymessage = explode(" ", $getmessage);
            $message = "";
            for ($i = 5; $i <= 10; $i++) {
                $message .= $arraymessage[$i] . " ";
            }
            return redirect()->route('rekapbon.create')->with('fail', 'Gagal menambahkan data. Silahkan coba lagi. ' . $message);
        }
    }

    public function update($id, Request $request)
    {
        try {
            $total = (int) str_replace(".", "", $request->total);
            $jml_bayar = (int) str_replace(".", "", $request->jumlah_terbayar);

            $status = "";

            if ($jml_bayar < $total) {
                $status = "Belum Lunas";
            } else {
                $status = "Lunas";
            }

            DB::table('rekap_bon')->where('id_bon', $id)->update([
                'id_cabang' => $request->id_cabang,
                'id_pelanggan' => $request->id_pelanggan,
                'tgl_bon' => $request->tgl_bon,
                'total' => $total,
                'jumlah_terbayar' => $jml_bayar,
                'status' => $status,
                'keterangan' => $request->keterangan,
                'updated_at' => Carbon::now(),
                'updated_by' => auth()->user()->name,
            ]);
            return redirect()->route('rekapbon.edit',['id' => $id])->with('success', 'Berhasil mengedit data');
        } catch (Exception $e) {
            return redirect()->back()->with('fail', 'Gagal mengedit data. Silahkan coba lagi');
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            
            $rekapbon = RekapBon::where('id_bon', $id)->first();

            $update = [
                'status_transaksi' => "Belum Lunas",
                'updated_at' => Carbon::now(),
                'updated_by' => "hapus bon - " . auth()->user()->name,
            ];

            Penjualan::where('id_penjualan', $rekapbon->id_penjualan)->update($update);

            /** delete record table rekap_bayar_bon */
            DB::table('rekap_bayar_bon')->where('id_bon', $id)->delete();
            /** delete record table penjualan */
            RekapBon::destroy($id);

            DB::commit();
            return redirect()->back()->with('success', 'Berhasil menghapus data');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('fail', 'Gagal menghapus data. Silahkan coba lagi');
        }
    }
}
