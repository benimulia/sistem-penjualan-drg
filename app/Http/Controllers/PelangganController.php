<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Exception;
use Carbon\Carbon;
use App\Models\Pelanggan;

class PelangganController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:pelanggan-list|pelanggan-create|pelanggan-edit|pelanggan-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:pelanggan-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:pelanggan-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:pelanggan-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $pelanggan = Pelanggan::latest()->get();
        return view('pelanggan.index', compact('pelanggan'), [
            "title" => "List Pelanggan"
        ]);
    }

    public function create()
    {
        return view('pelanggan.create', [
            "title" => "Tambah Pelanggan"
        ]);
    }

    public function edit($id)
    {
        $pelanggan = Pelanggan::find($id);
        return view('pelanggan.edit', compact('pelanggan'), [
            "title" => "Edit Pelanggan"
        ]);
    }

    public function store(Request $request)
    {
        try {
            if ($request->foto_pelanggan != null && $request->foto_identitas != null) {
                $extensionfotopelanggan = $request->foto_pelanggan->getClientOriginalExtension();
                $extensionfotoidentitas = $request->foto_identitas->getClientOriginalExtension();

                $nameImagePelanggan = $request->nama_pelanggan . "-" . time() . "." . $extensionfotopelanggan;
                $request->foto_pelanggan->move(public_path() . '/gambar/pelanggan/foto-pelanggan', $nameImagePelanggan);

                $nameImageIdentitas = $request->nama_pelanggan . "-" . time() . "-identitas" . "." . $extensionfotoidentitas;
                $request->foto_identitas->move(public_path() . '/gambar/pelanggan/foto-pelanggan', $nameImageIdentitas);
            } else {
                $nameImagePelanggan = null;
                $nameImageIdentitas = null;
            }
        } catch (Exception $e) {
            return redirect()->route('pelanggan.index')->with('fail', 'Gagal construct data. Silahkan coba lagi');
        }

        try {
            Pelanggan::create([
                'nama_pelanggan' => $request->nama_pelanggan,
                'no_hp' => $request->no_hp,
                'foto_pelanggan' => $nameImagePelanggan,
                'foto_identitas' => $nameImageIdentitas,
                'alamat_pelanggan' => $request->alamat_pelanggan,
            ]);
            return redirect()->route('pelanggan.index')->with('success', 'Berhasil menambahkan data');
        } catch (Exception $e) {
            return redirect()->route('pelanggan.create')->with('fail', 'Gagal menyimpan data. Silahkan coba lagi');
        }
    }

    public function update($id, Request $request)
    {
        $pelanggan = Pelanggan::find($id);
        $fotopelanggan = $pelanggan->foto_pelanggan;
        $fotoidentitas = $pelanggan->foto_identitas;

        // jika request mengandung foto baru maka hapus dan bikin format nama baru
        try {
            if ($request->foto_pelanggan != null) {
                $extensionfotopelanggan = $request->foto_pelanggan->getClientOriginalExtension();
                
                $file = public_path('/gambar/pelanggan/foto-pelanggan/') . $fotopelanggan;
                if (file_exists($file)) {
                    unlink($file);
                }
                // format nama foto + upload foto
                $nameImagePelanggan = $request->nama_pelanggan . "-" . time() . "." . $extensionfotopelanggan;
                $request->foto_pelanggan->move(public_path() . '/gambar/pelanggan/foto-pelanggan', $nameImagePelanggan);
            } else {
                // jika tidak ttp gunakan data dari db foto lama utk namane
                $nameImagePelanggan = $pelanggan->foto_pelanggan;
            }

            if ($request->foto_identitas != null) {
                $extensionfotoidentitas = $request->foto_identitas->getClientOriginalExtension();
                $fileidentitas = public_path('/gambar/pelanggan/foto-pelanggan/') . $fotoidentitas;
                if (file_exists($fileidentitas)) {
                    unlink($fileidentitas);
                }
                // format nama foto + upload foto
                $nameImageIdentitas = $request->nama_pelanggan . "-" . time() . "-identitas" . "." . $extensionfotoidentitas;
                $request->foto_identitas->move(public_path() . '/gambar/pelanggan/foto-pelanggan', $nameImageIdentitas);
            } else {
                // jika tidak ttp gunakan data dari db foto lama utk namane
                $nameImageIdentitas = $pelanggan->foto_identitas;
            }
        } catch (Exception $e) {
            return redirect()->route('pelanggan.edit', ['id' => $pelanggan->id_pelanggan])->with('fail', 'Gagal construct data. Silahkan coba lagi');
        }


        try {
            DB::table('pelanggan')->where('id_pelanggan', $id)->update([
                'nama_pelanggan' => $request->nama_pelanggan,
                'no_hp' => $request->no_hp,
                'foto_pelanggan' => $nameImagePelanggan,
                'foto_identitas' => $nameImageIdentitas,
                'alamat_pelanggan' => $request->alamat_pelanggan,
                'updated_at' => Carbon::now()
            ]);
            return redirect()->route('pelanggan.index')->with('success', 'Berhasil mengedit data');
        } catch (Exception $e) {
            return redirect()->route('pelanggan.edit')->with('fail', 'Gagal mengedit data. Silahkan coba lagi');
        }
    }

    public function destroy($id)
    {
        $pelanggan = Pelanggan::find($id);
        $fotopelanggan = $pelanggan->foto_pelanggan;
        $fotoidentitas = $pelanggan->foto_identitas;

        try {
            //delete foto
            $file = public_path('/gambar/pelanggan/foto-pelanggan/') . $fotopelanggan;
            if (file_exists($file)) {
                unlink($file);
            }

            $file1 = public_path('/gambar/pelanggan/foto-pelanggan/') . $fotoidentitas;
            if (file_exists($file1)) {
                unlink($file1);
            }

            $pelanggan->delete();
            return redirect()->route('pelanggan.index')->with('success', 'Berhasil menghapus data');
        } catch (Exception $e) {
            return redirect()->route('pelanggan.index')->with('fail', 'Gagal menghapus data. Silahkan coba lagi');
        }
    }
}
