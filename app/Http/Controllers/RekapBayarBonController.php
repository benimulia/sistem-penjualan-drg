<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\Penjualan;
use App\Models\RekapBayarBon;
use App\Models\RekapBon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class RekapBayarBonController extends Controller
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
            $rekapbayarbon = RekapBayarBon::with('cabang','rekapbon')->latest()->get();
        }else{
            $rekapbayarbon = RekapBayarBon::with('cabang','rekapbon')->latest()->where('id_cabang', $id_cabang)->get();
        }

        return view('rekapbayarbon.index', compact('rekapbayarbon'), [
            "title" => "List Rekap Bon"
        ]);

    }

    public function create($id)
    {
        $rekapbon = RekapBon::with('penjualan')->find($id);
        return view('rekapbayarbon.create', compact('rekapbon'), [
            "title" => "Bayar Bon"
        ]);
    }

    public function edit($id)
    {
        $rekapbon = RekapBon::with('penjualan')->find($id);
        $cabang = Cabang::all();
        $pelanggan = Pelanggan::orderBy('nama_pelanggan', 'ASC')->get();

        return view('rekapbon.edit', compact('rekapbon', 'cabang','pelanggan'), [
            "title" => "Lihat Rekap Bon"
        ]);
    }

    public function store($id,Request $request)
    {
        DB::beginTransaction();
        try {
            $jml_bayar = (int) str_replace(".", "", $request->jumlah_cicil);

            $rekapbon = RekapBon::where('id_bon', $id)->first();
            

            $jumlahbon = $rekapbon->total;
            $jumlahterbayar = $rekapbon->jumlah_terbayar;
    
            $jumlahterbayarupdate = $jumlahterbayar + $jml_bayar;

            if($jumlahterbayarupdate == $jumlahbon){

                if($rekapbon->id_penjualan != null){
                    $penjualan = Penjualan::where('id_penjualan', $rekapbon->id_penjualan)->first();
                    $updatepenjualan = [
                        'status_transaksi' => "Lunas",
                        'updated_by' => "bayar bon - " . auth()->user()->name,
                        'updated_date' => Carbon::now(),
                    ];

                    $penjualan->update($updatepenjualan);
                }

                $update = [
                    'jumlah_terbayar' => $jumlahterbayarupdate,
                    'status' => "Lunas",
                    'updated_by' => "bayar bon - " . auth()->user()->name,
                    'updated_date' => Carbon::now(),
                ];

                $rekapbon->update($update);
                
            }
            elseif($jumlahterbayarupdate < $jumlahbon){
                $update = [
                    'jumlah_terbayar' => $jumlahterbayarupdate,
                    'updated_by' => "bayar bon - " . auth()->user()->name,
                    'updated_date' => Carbon::now(),
                ];
                $rekapbon->update($update);
            }else{
                return redirect()->back()->with('fail', 'Jumlah bayar melebihi total bon');
            }
            

            $rekapbayarbon = new RekapBayarBon();
            $rekapbayarbon->id_bon = $id;
            $rekapbayarbon->tgl_bayar = $request->tgl_bayar;
            $rekapbayarbon->jumlah_cicil = $jml_bayar;
            $rekapbayarbon->keterangan = $request->keterangan;
            $rekapbayarbon->created_by = auth()->user()->name;
            $rekapbayarbon->updated_by = auth()->user()->name;

            $rekapbayarbon->save();
    
    
            DB::commit();
            return redirect()->route('rekapbon.edit', ['id' => $rekapbon->id_bon])->with('success', 'Berhasil menambahkan data bayar bon');
        } catch (Exception $e) {
            return redirect()->back()->with('fail', 'Gagal menambahkan data. Silahkan coba lagi');
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
            return redirect()->route('rekapbon.index')->with('success', 'Berhasil mengedit data');
        } catch (Exception $e) {
            return redirect()->back()->with('fail', 'Gagal mengedit data. Silahkan coba lagi');
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            
            $rekapbayarbon = RekapBayarBon::where('id_bayar_bon', $id)->first();
            $rekapbon = RekapBon::where('id_bon', $rekapbayarbon->id_bon)->first();

            $update = [
                'status_transaksi' => "Belum Lunas",
                'updated_at' => Carbon::now(),
                'updated_by' => "hapus bayar bon - " . auth()->user()->name,
            ];

            $jumlahterbayar = (int) $rekapbon->jumlah_terbayar;
            $jumlahcicil = (int) $rekapbayarbon->jumlah_cicil;
            $updatejumlahterbayar = $jumlahterbayar - $jumlahcicil;

            $updaterekapbon = [
                'status' => "Belum Lunas",
                'jumlah_terbayar' => $updatejumlahterbayar,
                'updated_at' => Carbon::now(),
                'updated_by' => "hapus bayar bon - " . auth()->user()->name,
            ];

            Penjualan::where('id_penjualan', $rekapbon->id_penjualan)->update($update);
            RekapBon::where('id_bon', $rekapbayarbon->id_bon)->update($updaterekapbon);

            /** delete record table rekap_bayar_bon */
            RekapBayarBon::destroy($id);

            DB::commit();
            return redirect()->back()->with('success', 'Berhasil menghapus data');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('fail', 'Gagal menghapus data. Silahkan coba lagi');
        }
    }
}
