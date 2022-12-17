@extends('layouts.master')
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

<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="pull-left">
            <h2>Tambah Cabang Baru</h2>
        </div>
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('cabang.index') }}">Cabang</a></li>
                <li class="breadcrumb-item"><a href="#">Tambah Cabang</a></li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-sm-12 col-md-12">
        <form id="beritaForm" class="needs-validation" novalidate action="{{route('cabang.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="nama_cabang">Nama Cabang :</label>
                <input type="text" class="form-control" id="nama_cabang" placeholder="Masukkan nama cabang.." name="nama_cabang" required>
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    Please fill out this field.
                </div>
            </div>
            <div class="form-group">
                <label for="kategori">Kategori :</label>
                <div class="w-100"></div>
                <select class="form-control" id="kategori" name="kategori" required>
                    <option value="">Pilih Kategori</option>
                    <option value="Pakan">Pakan</option>
                    <option value="Telur">Telur</option>
                </select>
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    Please fill out this field.
                </div>
            </div>
            <div class="form-group">
                <label for="alamat_cabang">Alamat Cabang :</label>
                <input type="text" class="form-control" id="alamat_cabang" placeholder="Masukkan alamat cabang.." name="alamat_cabang" required>
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    Please fill out this field.
                </div>
            </div>
            <div class="form-group">
                <label for="tgl_buka">Tanggal Buka Cabang :</label>
                <input class="datepicker form-control" type="text" id="tgl_buka" name="tgl_buka" placeholder="Masukkan tanggal buka cabang.." required>
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    Please fill out this field.
                </div>
            </div>
            <div class="">
                <a href="{{route('cabang.index')}}" class="btn btn-danger mr-2">Batal</a>
                <button type="submit" id="btn-save" name="btnsave" class="btn btn-primary">Submit</button>

            </div>

        </form>
    </div>
</div>
@endsection

@section('body-script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet" />
@endsection

@section('footer-script')
<script type="text/javascript">
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
        endDate: new Date(new Date().setDate(new Date().getDate()))
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
</script>
@endsection