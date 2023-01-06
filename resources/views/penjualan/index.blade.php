@extends('layouts.master')

@section('style')
<!-- Custom styles for this template-->
<link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
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
<h1 class="h3 mb-2 text-gray-800">Penjualan</h1>
<p class="mb-4">Halaman ini digunakan untuk menampilkan dan mengelola daftar penjualan produk.</p>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Penjualan</h6>
    </div>
    <div class="card-body">
        <div class="row ml-0">
            <a href="{{route('penjualan.create')}}" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Tambah Penjualan Baru</span>
            </a>
        </div>
        <div class="my-4"></div>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="text-center" style="width:20px;">No</th>
                        <th class="text-center">Cabang</th>
                        <th class="text-center" style="width:120px;">Tgl</th>
                        <th class="text-center" style="width:170px;">Total</th>
                        <th class="text-center" style="width:80px;">Status</th>
                        <th class="text-center" style="width:200px;">Keterangan</th>
                        <th class="text-center">User</th>
                        <th data-orderable="false"></th>
                        <th data-orderable="false"></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($penjualan as $index => $result)
                    <tr>
                        <td class="text-center" style="min-width:20px">{{$index + 1}}</td>
                        <td>{{$result->cabang->nama_cabang}}</td>
                        <td style="min-width:120px" >{{$result->created_at}}</td>
                        <td style="min-width:170px">Rp {{number_format($result->total_penjualan,0,',','.') }}</td>
                        <td style="min-width:80px">{{$result->status_transaksi}}</td>
                        <td style="min-width:200px">{{$result->keterangan}}</td>
                        <td>{{$result->created_by}}</td>
                        <td class="text-center">
                            <a href="{{ route('penjualan.edit',['id' => $result->id_penjualan]) }}" class="btn btn-success text-light btb-circle" id="edit-penjualan">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                        <td class="text-center">
                            <a data-id="{!! $result->id_penjualan !!}" data-target="#previewModal-{{ $result->id_penjualan }}" data-toggle="modal" class="btn btn-danger btn-circle">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                        <!-- Modal HTML -->
                        <div class="modal fade" tabindex="-1" id="previewModal-{{ $result->id_penjualan }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-warning dark">
                                        <h5 class="modal-title w-100 text-dark">Hapus Data?</h5>
                                        
                                        <a data-dismiss="modal" class="btn btn-secondary btn-circle">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </div>
                                    <div class="modal-body">
                                        <p>Apakah anda yakin untuk menghapus data? Data yang sudah dihapus tidak dapat kembali!</p>
                                        <small>Stok produk akan dikembalikan sesuai dengan transaksi yang dibuat</small>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        <a href="{{ route('penjualan.destroy',['id' => $result->id_penjualan]) }}" class="btn btn-danger text-light">
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

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script> -->
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
@endsection


@section('footer-script')
<script>
    // Call the dataTables jQuery plugin
    $(document).ready(function() {
        $('#dataTable').DataTable({
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
            lengthChange: true
        });
    });



    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function() {
            $(this).remove();
        });
    }, 5000);
</script>

@endsection