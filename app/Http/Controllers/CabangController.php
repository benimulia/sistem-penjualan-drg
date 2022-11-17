<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Exception;
use Carbon\Carbon;
use App\Models\Cabang;

class CabangController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:cabang-list|cabang-create|cabang-edit|cabang-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:cabang-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:cabang-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:cabang-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $cabang = Cabang::orderBy('created_at', 'desc')->get();
        return view('cabang.index', compact('cabang'), [
            "title" => "List Cabang"
        ]);
    }

    public function create()
    {
        return view('cabang.create', [
            "title" => "Tambah Cabang"
        ]);
    }

    public function edit($id)
    {
        $cabang = Cabang::find($id);
        return view('cabang.edit', compact('cabang'), [
            "title" => "Edit Cabang"
        ]);
    }

    public function store(Request $request)
    {
        try {
            Cabang::create([
                'nama_cabang' => $request->nama_cabang,
                'kategori' => $request->kategori,
                'alamat_cabang' => $request->alamat_cabang,
                'tgl_buka' => $request->tgl_buka,
            ]);
            return redirect()->route('cabang.index')->with('success', 'Berhasil menambahkan data');
        } catch (Exception $e) {
            return redirect()->route('cabang.create')->with('fail', 'Gagal menyimpan data. Silahkan coba lagi');
        }
    }

    public function update($id, Request $request)
    {
        $berita = Cabang::find($id);


        try {

            $jdlBerita = strval($request->judulBerita);
            $beritaIdentifier = str_replace(" ", "-", $jdlBerita);
            $beritaDb = strval($berita->judul_berita);

            if ($jdlBerita != $beritaDb) {
                $cariIdentifier = DB::table('beritas')->where('berita_identifier', '=', $beritaIdentifier)->pluck('berita_identifier');
                $counter = 1;
                while ($cariIdentifier->count() > 0) {
                    $beritaIdentifier = str_replace(" ", "-", $jdlBerita) . $counter;
                    $counter++;

                    $cariIdentifier = DB::table('beritas')->where('berita_identifier', '=', $beritaIdentifier)->pluck('berita_identifier');
                }
                $counter = 1;
            } else {
                $beritaIdentifier = $berita->berita_identifier;
            }


            $gambar = $berita->gambar_berita;
            if ($request->gambarBerita != null) {
                if ($gambar != null) {
                    $file = public_path('/gambarBerita/') . $gambar;
                    if (file_exists($file)) {
                        unlink($file);
                    }
                }

                $nameImage = time() . "-" . $request->gambarBerita->getClientOriginalName();
                $request->gambarBerita->move(public_path() . '/gambarBerita', $nameImage);
            } else {
                $nameImage = $gambar;
            }
        } catch (Exception $e) {
            return redirect('/adminku/berita')->with('fail', 'Gagal construct data. Silahkan coba lagi');
        }


        try {
            DB::table('beritas')->where('id', $id)->update([
                'berita_identifier' => $beritaIdentifier,
                'judul_berita' => $request->judulBerita,
                'gambar_berita' => $nameImage,
                'tgl_berita' => $request->tglBerita,
                'isi_berita' => $request->isiBerita,
                'penulis_berita' => $request->penulisBerita,
                'updated_at' => Carbon::now('+07:00')
            ]);
            return redirect('/adminku/berita')->with('success', 'Berhasil mengedit data');
        } catch (Exception $e) {
            return redirect('/adminku/berita')->with('fail', 'Gagal mengedit data. Silahkan coba lagi');
        }
    }

    public function destroy($id)
    {
        $berita = Cabang::find($id);

        try {
            $gambar = $berita->gambar_berita;
            if ($gambar != null) {
                $file = public_path('/gambarBerita/') . $gambar;
                if (file_exists($file)) {
                    unlink($file);
                }
            }

            $berita->delete();
            return redirect('/adminku/berita')->with('success', 'Berhasil menghapus data');
        } catch (Exception $e) {
            return redirect('/adminku/berita')->with('fail', 'Gagal menghapus data. Silahkan coba lagi');
        }
    }
}
