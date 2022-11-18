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

        try {
            DB::table('cabang')->where('id_cabang', $id)->update([
                'nama_cabang' => $request->nama_cabang,
                'kategori' => $request->kategori,
                'alamat_cabang' => $request->alamat_cabang,
                'tgl_buka' => $request->tgl_buka,
                'updated_at' => Carbon::now()
            ]);
            return redirect()->route('cabang.index')->with('success', 'Berhasil mengedit data');
        } catch (Exception $e) {
            return redirect()->route('cabang.edit')->with('fail', 'Gagal mengedit data. Silahkan coba lagi');
        }
    }

    public function destroy($id)
    {
        $cabang = Cabang::find($id);

        try {
            $cabang->delete();
            return redirect()->route('cabang.index')->with('success', 'Berhasil menghapus data');
        } catch (Exception $e) {
            return redirect()->route('cabang.index')->with('fail', 'Gagal menghapus data. Silahkan coba lagi');
        }
    }
}
