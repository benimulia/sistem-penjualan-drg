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
            <h2>Tambah Pelanggan Baru</h2>
        </div>
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('pelanggan.index') }}">Pelanggan</a></li>
                <li class="breadcrumb-item"><a href="#">Tambah Pelanggan</a></li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-sm-12 col-md-12">
        <form id="beritaForm" class="needs-validation" novalidate action="{{route('pelanggan.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="nama_pelanggan">Nama :</label>
                <input type="text" class="form-control" id="nama_pelanggan" placeholder="Masukkan nama.." name="nama_pelanggan" required>
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    Please fill out this field.
                </div>
            </div>
            <div class="form-group">
                <label for="no_hp">Nomor HP :</label>
                <input type="text" class="form-control" id="no_hp" placeholder="Masukkan no hp.." name="no_hp" maxlength="13" required>
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    Please fill out this field.
                </div>
            </div>
            <div class="form-group">
                <label for="alamat_pelanggan">Alamat :</label>
                <input type="text" class="form-control" id="alamat_pelanggan" placeholder="Masukkan alamat pelanggan.." name="alamat_pelanggan" required>
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    Please fill out this field.
                </div>
            </div>

            <div class="form-group">
                <label for="foto_pelanggan">Upload foto pelanggan:</label> <br>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="foto_pelanggan" name="foto_pelanggan" accept=".jpg,.jpeg,.png" required />
                    <label class="custom-file-label" for="foto_pelanggan">Masukkan foto pelanggan</label>
                </div>
                <div>
                    <small>*Ukuran Foto Maksimal 2Mb</small>
                </div>
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    Please fill out this field.
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 ">
                <img src="#" style="width: 90px; height: 130px; display:none" id="profile-img-tag">
            </div>

            <div class="form-group">
                <label for="foto_identitas">Upload foto identitas :</label> <br>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="foto_identitas" name="foto_identitas" accept=".jpg,.jpeg,.png" required />
                    <label class="custom-file-label" for="foto_identitas">Masukkan foto identitas</label>
                </div>
                <div>
                    <small>*Ukuran Foto Maksimal 2Mb</small>
                </div>
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    Please fill out this field.
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 ">
                <img src="#" style="width: 130px; height: 90px; display:none" id="identitas-img-tag">
            </div>


            <div class="mt-4">
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
    $('#no_hp').keypress(function(e) {
        var arr = [];
        var kk = e.which;

        for (i = 48; i < 58; i++)
            arr.push(i);

        if (!(arr.indexOf(kk) >= 0))
            e.preventDefault();
    });

    $('#foto_pelanggan').on('change', function() {
        //get the file name
        var fileName = $(this).val();
        //replace the "Choose a file" label
        $(this).next('.custom-file-label').html(fileName);
        readURL(this);

    })
    $('#foto_pelanggan').bind('change', function() {
        if (this.files[0].size / 1024 / 1024 > 2) {
            alert("Ukuran foto yang Anda masukkan lebih dari 2mb. Mohon input ulang");
            $(this).val('');
            $(this).next('.custom-file-label').html('Masukkan foto pelanggan');
        }
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            if (input.files[0].size / 1024 / 1024 < 2) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#profile-img-tag').attr('src', e.target.result);
                    $("#profile-img-tag").css("display", "");
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    }

    $('#foto_identitas').on('change', function() {
        //get the file name
        var fileName = $(this).val();
        //replace the "Choose a file" label
        $(this).next('.identitas-custom-file-label').html(fileName);
        readURL2(this);

    })
    $('#foto_identitas').bind('change', function() {
        if (this.files[0].size / 1024 / 1024 > 2) {
            alert("Ukuran gambar yang Anda masukkan lebih dari 2mb. Mohon input ulang");
            $(this).val('');
            $(this).next('.custom-file-label').html('Masukkan foto identitas');
        }
    });

    function readURL2(input) {
        if (input.files && input.files[0]) {
            if (input.files[0].size / 1024 / 1024 < 2) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#identitas-img-tag').attr('src', e.target.result);
                    $("#identitas-img-tag").css("display", "");
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    }

    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
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