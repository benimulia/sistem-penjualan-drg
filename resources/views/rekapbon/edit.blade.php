@extends('layouts.master')

@section('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/select2-bootstrap-5-theme.min.css') }}" />
@endsection

@section('content')
    @if ($message = Session::get('success'))
        <div class="container">
            <div class="row justify-content-center mt-5">
                <div class="col-md-5">
                    <div class="alert alert-success" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
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
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <strong>Failed!</strong> {{ $message }}
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="pull-left">
                <h2>Edit Rekap Bon </h2>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('rekapbon.index') }}">Rekap Bon</a></li>
                    <li class="breadcrumb-item"><a href="#">Edit Rekap Bon</a></li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row" style="margin-bottom: 30px;">
        <div class="col-sm-12 col-md-12">
            {{-- <a href="{{ route('rekapbon.index') }}" class="btn btn-danger mr-2">Kembali</a> --}}
            <a href="{{ route('rekapbon.index') }}" class="btn btn-danger"> <i class="fas fa-fw fa-arrow-left"></i>
                Kembali</a>
            <button id="btnEnableEdit" class="btn btn-info" onclick="enableInput();"> <i class="fas fa-fw fa-edit"></i> Edit
                Data</button>
            @if ($rekapbon->id_penjualan != null)
                <a href="{{ route('penjualan.edit', ['id' => $rekapbon->penjualan->id_penjualan]) }}" class="btn btn-info"
                    target="_blank"> <i class="fas fa-fw fa-eye"></i> Lihat Transaksi</a>
            @endif
            @if ($rekapbon->total != $rekapbon->jumlah_terbayar)
                <a href="{{ route('rekapbayarbon.create', ['id' => $rekapbon->id_bon]) }}" class="btn btn-info">
                    <i class="fas fa-fw fa-money-bill-wave"></i>
                    Bayar Bon
                </a>
            @endif
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-sm-12 col-md-12">
            <div class="pull-left">
                <h5><span
                        class="badge p-3 {{ $rekapbon->status == 'Belum Lunas' ? 'badge-warning text-dark' : 'badge-success' }}">#
                        Status Bon : {{ $rekapbon->status }}</span></h5>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 col-md-12">
            <form id="rekapbonForm" class="needs-validation" novalidate
                action="{{ route('rekapbon.update', ['id' => $rekapbon->id_bon]) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="d-flex">
                    <p class="mr-2"> <b>Dibuat oleh :</b> <span
                            class="badge badge-secondary">{{ $rekapbon->created_by }}</span> </p>
                    <p class="mr-2"> <b>Dibuat pada :</b> <span
                            class="badge badge-secondary">{{ $rekapbon->created_at }}</span> </p>
                    <p class="mr-2"> <b>Terakhir diubah oleh :</b> <span
                            class="badge badge-secondary">{{ $rekapbon->updated_by }}</span> </p>
                    <p class="mr-2"> <b>Terakhir diubah pada :</b> <span
                            class="badge badge-secondary">{{ $rekapbon->updated_at }}</span> </p>
                </div>
                <input type="hidden" id="id_bon" name="id_bon">
                @if (auth()->user()->id_cabang == 0)
                    <div class="form-group">
                        <label for="id_cabang">Cabang :</label>
                        <div class="w-100"></div>
                        <select class="form-control select2" id="id_cabang" name="id_cabang" required disabled=true>
                            <option value="">Pilih Cabang</option>
                            @foreach ($cabang as $result)
                                <option value="{{ $result->id_cabang }}"
                                    {{ $rekapbon->id_cabang == $result->id_cabang ? 'selected' : '' }}>
                                    {{ $result->nama_cabang }}</option>
                            @endforeach
                        </select>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Please fill out this field.
                        </div>
                    </div>
                @else
                    <input type="hidden" name="id_cabang" value="{{ auth()->user()->id_cabang }}">
                @endif

                <div class="row">
                    <div class="col-sm-6 col-md-6">
                        <div class="form-group">
                            <label for="id_pelanggan">Nama Pelanggan :</label>
                            <select class="form-control select2" id="id_pelanggan" name="id_pelanggan" disabled required>
                                <option value="">Pilih Pelanggan</option>
                                @foreach ($pelanggan as $result)
                                    <option value="{{ $result->id_pelanggan }}"
                                        {{ $rekapbon->id_pelanggan == $result->id_pelanggan ? 'selected' : '' }}>
                                        {{ $result->nama_pelanggan }}</option>
                                @endforeach
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please fill out this field.
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-6">
                        <div class="form-group">
                            <label for="tgl_bon">Tanggal Bon :</label>
                            <input class="datepicker form-control px-2" type="text" id="tgl_bon" name="tgl_bon"
                                placeholder="Masukkan tanggal bon.." value="{{ $rekapbon->tgl_bon }}" disabled required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please fill out this field.
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-6">
                        <div class="form-group">
                            <label for="total">Jumlah Bon :</label>
                            <input class="form-control angka" type="text" id="total" name="total"
                                value="{{ number_format($rekapbon->total, 0, ',', '.') }}" disabled required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please fill out this field.
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-6">
                        <div class="form-group">
                            <label for="jumlah_terbayar">Jumlah Terbayar :</label>
                            <input class="form-control angka" type="text" id="jumlah_terbayar" name="jumlah_terbayar"
                                value="{{ number_format($rekapbon->jumlah_terbayar, 0, ',', '.') }}" disabled required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please fill out this field.
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-6">
                        <div class="form-group">
                            <label for="sisa_bon">Sisa Bon :</label>
                            <input class="form-control angka" type="text" id="sisa_bon" name="sisa_bon"
                                value="{{ number_format($rekapbon->total - $rekapbon->jumlah_terbayar, 0, ',', '.') }}"
                                readonly required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please fill out this field.
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <div class="form-group">
                            <label for="keterangan">Keterangan :</label>
                            <textarea class="form-control" rows="3" id="keterangan" name="keterangan" disabled>{{ $rekapbon->keterangan }}</textarea>
                            <small>*tidak wajib diisi</small>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please fill out this field.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="">
                    <a href="" id="btnBatal" class="btn btn-danger mr-2" style="display: none;">Batal</a>
                    <a href="#myModal" id="btnUpdate" data-toggle="modal" class="btn btn-success"
                        style="display: none;">Update </a>
                </div>

                <!-- Modal HTML -->
                <div id="myModal" class="modal fade">
                    <div class="modal-dialog modal-confirm">
                        <div class="modal-content">
                            <div class="modal-header bg-info text-light">
                                <h5 class="modal-title w-100">Edit Data?</h5>
                                <a data-dismiss="modal" class="btn btn-secondary btn-circle">
                                    <i class="fas fa-times"></i>
                                </a>
                            </div>
                            <div class="modal-body">
                                <p>Apakah anda yakin untuk mengedit data?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button id="submit" type="submit" class="btn btn-success">Ya</button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
    <div class="my-4"></div>
    <hr>

    <div class="row ml-0 justify-content-center">
        <h3>Detail Rekap Pembayaran</h3>
    </div>
    <div class="my-4"></div>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Tanggal Bayar</th>
                            <th class="text-center">Jumlah Cicil</th>
                            <th class="text-center">Keterangan</th>
                            <th class="text-center">Created by</th>
                            <th class="text-center">Created at</th>
                            @can('rekapbon-delete')
                                <th data-orderable="false"></th>
                            @endcan
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($rekapbayarbon as $index => $result)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $result->tgl_bayar }}</td>
                                <td>Rp {{ number_format($result->jumlah_cicil, 0, ',', '.') }}</td>
                                <td>{{ $result->keterangan }}</td>
                                <td>{{ $result->created_by }}</td>
                                <td>{{ $result->created_at }}</td>
                                @can('rekapbon-delete')
                                    <td class="text-center">
                                        <a data-id="{!! $result->id_bayar_bon !!}"
                                            data-target="#previewModal-{{ $result->id_bayar_bon }}" data-toggle="modal"
                                            class="btn btn-danger btn-circle">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                @endcan
                                <!-- Modal HTML -->
                                <div class="modal fade" tabindex="-1" id="previewModal-{{ $result->id_bayar_bon }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-warning dark">
                                                <h5 class="modal-title w-100 text-dark">Hapus Data?</h5>

                                                <a data-dismiss="modal" class="btn btn-secondary btn-circle">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            </div>
                                            <div class="modal-body">
                                                <p>Apakah anda yakin untuk menghapus data? Data yang sudah dihapus tidak
                                                    dapat kembali!</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Batal</button>
                                                <a href="{{ route('rekapbayarbon.destroy', ['id' => $result->id_bayar_bon]) }}"
                                                    class="btn btn-danger text-light">
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
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css"
        rel="stylesheet" />
@endsection

@section('footer-script')
    <script type="text/javascript">
        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });

        $(document).ready(function() {
            $('#id_cabang').select2({
                placeholder: "Pilih Cabang",
                allowClear: true,
                theme: "bootstrap-5",
            });
            $('#id_pelanggan').select2({
                placeholder: "Pilih Pelanggan",
                allowClear: true,
                theme: "bootstrap-5",
            });
        });

        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                            $('#myModal').modal('hide');
                            $("html, body").animate({
                                scrollTop: 0
                            }, "slow");
                            form.classList.add('was-validated');
                            return false;
                        }
                        form.classList.add('was-validated');
                    }, false);
                });

            }, false);
        })();

        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            endDate: new Date(new Date().setDate(new Date().getDate()))
        });

        $(".angka").on("keyup", function(event) {
            // When user select text in the document, also abort.
            var selection = window.getSelection().toString();
            if (selection !== '') {
                return;
            }
            // When the arrow keys are pressed, abort.
            if ($.inArray(event.keyCode, [38, 40, 37, 39]) !== -1) {
                return;
            }
            var $this = $(this);
            // Get the value.
            var input = $this.val();
            input = input.replace(/[\D\s\._\-]+/g, "");
            input = input ? parseInt(input, 10) : 0;
            $this.val(function() {
                return (input === 0) ? "0" : input.toLocaleString("id-ID");
            });
        });

        function enableInput() {
            var inputs = document.getElementsByClassName('form-control');
            for (var i = 0; i < inputs.length; i++) {
                inputs[i].disabled = false;
            }
            $("#btnUpdate").css("display", "");
            $("#btnEnableEdit").css("display", "none");
            $("#btnBatal").css("display", "");
        }
    </script>
@endsection
