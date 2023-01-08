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
                <h2>Bayar Bon</h2>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('rekapbon.index') }}">Rekap Bon</a></li>
                    <li class="breadcrumb-item"><a href="#">Bayar Bon</a></li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 col-md-12">
            <form id="rekapbayarbonForm" class="needs-validation" novalidate action="{{ route('rekapbayarbon.store', ['id' => $rekapbon->id_bon]) }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="tgl_bayar">Tanggal Bayar Bon :</label>
                    <input class="datepicker form-control px-2" type="text" id="tgl_bayar" name="tgl_bayar"
                        placeholder="Masukkan tanggal bayar bon.." required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please fill out this field.
                    </div>
                </div>

                <div class="form-group">
                    <label for="jumlah_cicil">Jumlah Bayar :</label>
                    <input class="form-control angka" type="text" id="jumlah_cicil" name="jumlah_cicil" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please fill out this field.
                    </div>
                </div>
                <div class="form-group">
                    <label for="keterangan">Keterangan :</label>
                    <textarea class="form-control" rows="3" id="keterangan" name="keterangan"></textarea>
                    <small>*tidak wajib diisi</small>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please fill out this field.
                    </div>
                </div>

                <div class="">
                    <a href="{{ url()->previous() }}" class="btn btn-danger mr-2">Batal</a>
                    <button type="submit" id="btn-save" name="btnsave" class="btn btn-primary">Submit</button>

                </div>

            </form>
        </div>
    </div>
@endsection

@section('body-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css"
        rel="stylesheet" />
@endsection

@section('footer-script')
    <script type="text/javascript">
        $(document).ready(function() {
            document.getElementById('tgl_bayar').value = getTanggal();
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

        function getTanggal() {
            var today = new Date();
            var dd = today.getDate();

            var mm = today.getMonth() + 1;
            var yyyy = today.getFullYear();
            if (dd < 10) {
                dd = '0' + dd;
            }

            if (mm < 10) {
                mm = '0' + mm;
            }

            return today = yyyy + '-' + mm + '-' + dd;

        }
    </script>
@endsection
