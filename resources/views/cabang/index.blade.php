

@extends('layouts.master')

@section('style')
<!-- Custom styles for this template-->
<link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@endsection

@section('content')

@if ($message = Session::get('success'))
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-5">
            <div class="alert alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Success!</strong> {{ $message }}
            </div>
        </div>
    </div>
</div>
@endif

@if ($message = Session::get('fail'))
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-5">
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Failed!</strong> {{ $message }}
            </div>
        </div>
    </div>
</div>
@endif

<!-- Content Row -->
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Cabang</h1>
<p class="mb-4">Halaman ini digunakan untuk menampilkan dan mengelola daftar cabang.</p>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Cabang</h6>
    </div>
    <div class="card-body">
        <div class="row ml-0">
            <a href="{{route('cabang.create')}}" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Tambah Cabang</span>
            </a>
        </div>
        <div class="my-4"></div>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama Cabang</th>
                        <th class="text-center">Kategori</th>
                        <th class="text-center">Tgl Buka Cabang</th>
                        <th class="text-center">Alamat</th>
                        <th data-orderable="false"></th>
                        <th data-orderable="false"></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($cabang as $index => $result)
                    <tr>
                        <td class="text-center">{{$index + 1}}</td>
                        <td>{{\Illuminate\Support\Str::limit( html_entity_decode(strip_tags($result->nama_cabang)), 50 )}}</td>
                        <td>{{$result->kategori}}</td>
                        <td>{{date('Y M d', strtotime($result->tgl_buka))}}</td>
                        <td>{{$result->alamat}}</td>
                        <td class="text-center">
                            <a data-id="{!! $result->id_cabang !!}" data-target="#previewModal-{{ $result->id_cabang }}" data-toggle="modal" class="btn btn-danger btn-circle">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('cabang.edit',['id' => $result->id_cabang]) }}" class="btn btn-success text-light btb-circle" id="edit-cabang">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                        <!-- Modal HTML -->
                        <div class="modal fade" tabindex="-1" id="previewModal-{{ $result->id_cabang }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-warning dark">
                                        <h5 class="modal-title w-100 text-dark">Hapus Data?</h5>
                                        <!-- <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">&times;</button> -->
                                        <a data-dismiss="modal" class="btn btn-secondary btn-circle">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </div>
                                    <div class="modal-body">
                                        <p>Apakah anda yakin untuk menghapus data? Data yang sudah dihapus tidak dapat kembali!</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        <a href="{{ route('cabang.destroy',['id' => $result->id_cabang]) }}" class="btn btn-danger text-light">
                                            Hapus
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('body-script')

<!-- Page level plugins -->
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
<!-- Page level custom scripts -->
<script src="{{ asset('js/demo/datatables-demo.js')}}"></script>
@endsection


@section('footer-script')
<script>
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function() {
            $(this).remove();
        });
    }, 5000);
</script>

@endsection