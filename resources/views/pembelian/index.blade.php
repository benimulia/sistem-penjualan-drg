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
<h1 class="h3 mb-2 text-gray-800">Pembelian</h1>
<p class="mb-4">Halaman ini digunakan untuk menampilkan dan mengelola daftar pembelian produk.</p>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Pembelian</h6>
    </div>
    <div class="card-body">
        @can('pembelian-create')
        <div class="row ml-0">
            <a href="{{route('pembelian.create')}}" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Tambah Pembelian Baru</span>
            </a>
        </div>
        @endcan
        <div class="my-4"></div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                <thead class="bg-info text-white">
                    <tr>
                        <th class="text-center" style="width:20px;">No</th>
                        @if(auth()->user()->id_cabang==0)
                        <th class="text-center">Cabang</th>
                        @endif
                        <th class="text-center" style="width:120px;">Tgl Pembelian</th>
                        <th class="text-center">Supplier</th>
                        <th class="text-center" style="width:170px;">Total Pembelian</th>
                        <th class="text-center" style="width:200px;">Keterangan</th>
                        <th class="text-center">User</th>
                        <th class="text-center" style="width:120px;">Created</th>
                        @can('pembelian-edit')
                        <th data-orderable="false"></th>
                        @endcan
                        @can('pembelian-delete')
                        <th data-orderable="false"></th>
                        @endcan
                    </tr>
                </thead>

                <tbody>
                    @foreach ($pembelian as $index => $result)
                    <tr>
                        <td class="text-center" style="min-width:20px">{{$index + 1}}</td>
                        @if(auth()->user()->id_cabang==0)
                        <td>{{$result->cabang->nama_cabang}}</td>
                        @endif
                        <td>{{$result->tgl_pembelian}}</td>
                        <td>{{$result->supplier}}</td>
                        <td>Rp {{number_format($result->total_pembelian,0,',','.') }}</td>
                        <td>{{$result->keterangan}}</td>
                        <td>{{$result->created_by}}</td>
                        <td>{{$result->created_at}}</td>
                        @can('pembelian-edit')
                        <td class="text-center">
                            <a href="{{ route('pembelian.edit',['id' => $result->id_pembelian]) }}" class="btn btn-success text-light btb-circle" id="edit-pembelian">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                        @endcan
                        @can('pembelian-delete')
                        <td class="text-center">
                            <a data-id="{!! $result->id_pembelian !!}" data-target="#previewModal-{{ $result->id_pembelian }}" data-toggle="modal" class="btn btn-danger btn-circle">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                        @endcan
                        <!-- Modal HTML -->
                        <div class="modal fade" tabindex="-1" id="previewModal-{{ $result->id_pembelian }}">
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
                                        <small>Stok produk juga akan berkurang sesuai yang tertera dalam pembelian</small>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        <a href="{{ route('pembelian.destroy',['id' => $result->id_pembelian]) }}" class="btn btn-danger text-light">
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
</script>

@endsection