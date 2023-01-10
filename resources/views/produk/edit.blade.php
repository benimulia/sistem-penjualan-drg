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
                <h2>Edit Produk </h2>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('produk.index') }}">Produk</a></li>
                    <li class="breadcrumb-item"><a href="#">Edit Produk</a></li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row" style="margin-bottom: 30px;">
        <div class="col-sm-12 col-md-12">
            <button id="btnEnableEdit" class="btn btn-info" onclick="enableInput();">Edit Data</button>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <form id="produkForm" class="needs-validation" novalidate
                action="{{ route('produk.update', ['id' => $produk->id_produk]) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="id_produk" name="id_produk">

                @if (auth()->user()->id_cabang == 0)
                    <div class="form-group">
                        <label for="id_cabang">Cabang :</label>
                        <div class="w-100"></div>
                        <select class="form-control select2" id="id_cabang" name="id_cabang" required disabled=true>
                            <option value="">Pilih Cabang</option>
                            @foreach ($cabang as $result)
                                <option value="{{ $result->id_cabang }}"
                                    {{ $produk->id_cabang == $result->id_cabang ? 'selected' : '' }}>
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

                <div class="form-group">
                    <label for="nama_produk">Nama Produk :</label>
                    <input type="text" class="form-control" id="nama_produk" placeholder="Masukkan nama produk.."
                        name="nama_produk" required value="{{ $produk->nama_produk }}" disabled=true>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please fill out this field.
                    </div>
                </div>
                <div class="form-group">
                    <label for="stok">Stok :</label>
                    <input type="number" class="form-control" id="stok" placeholder="Masukkan stok produk.."
                        name="stok" required onkeypress='validateInt(event)' value="{{ $produk->stok }}" disabled=true>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please fill out this field.
                    </div>
                </div>

                <div class="form-group">
                    <label for="satuan">Satuan :</label>
                    <div class="w-100"></div>
                    <select class="form-control select2" id="satuan" name="satuan" required disabled=true>
                        <option value="">Pilih Satuan</option>
                        <option value="ikat" {{ $produk->satuan == 'ikat' ? 'selected' : '' }}>ikat</option>
                        <option value="botol" {{ $produk->satuan == 'botol' ? 'selected' : '' }}>botol</option>
                        <option value="bungkus" {{ $produk->satuan == 'bungkus' ? 'selected' : '' }}>bungkus</option>
                        <option value="butir" {{ $produk->satuan == 'butir' ? 'selected' : '' }}>butir</option>
                        <option value="kg" {{ $produk->satuan == 'kg' ? 'selected' : '' }}>kg</option>
                        <option value="pieces" {{ $produk->satuan == 'pieces' ? 'selected' : '' }}>pieces</option>
                        <option value="tray" {{ $produk->satuan == 'tray' ? 'selected' : '' }}>tray</option>
                    </select>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please fill out this field.
                    </div>
                </div>
                <div class="form-group">
                    <label for="harga_cash">Harga Cash :</label>
                    <input type="text" class="form-control angka" id="harga_cash"
                        placeholder="Masukkan harga cash produk.." name="harga_cash" required
                        value="{{number_format($produk->harga_cash,0,',','.') }}" disabled=true>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please fill out this field.
                    </div>
                </div>
                <div class="form-group">
                    <label for="harga_bon">Harga Bon :</label>
                    <input type="text" class="form-control angka" id="harga_bon"
                        placeholder="Masukkan harga bon produk.." name="harga_bon" required
                        value="{{number_format($produk->harga_bon,0,',','.') }}" disabled=true>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please fill out this field.
                    </div>
                </div>
                <div class="form-group">
                    <label for="harga_beli">Harga Beli :</label>
                    <input type="text" class="form-control angka" id="harga_beli"
                        placeholder="Masukkan harga beli produk.." name="harga_beli" required
                        value="{{number_format($produk->harga_beli,0,',','.') }}" disabled=true>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please fill out this field.
                    </div>
                </div>
                <div class="form-group">
                    <label for="diskon">Diskon :</label>
                    <input type="text" class="form-control angka" id="diskon"
                        placeholder="Masukkan diskon produk.." name="diskon" required value="{{number_format($produk->diskon,0,',','.') }}"
                        disabled=true>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please fill out this field.
                    </div>
                </div>
                <div class="">
                    <a href="" style="display: none;" class="btn btn-danger mr-2" id="btnBatal">Batal</a>
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
@endsection

@section('body-script')
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
            $('#satuan').select2({
                placeholder: "Pilih Satuan",
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
            $("#btnBatal").css("display", "");
            $("#btnEnableEdit").css("display", "none");
        }
    </script>
@endsection
