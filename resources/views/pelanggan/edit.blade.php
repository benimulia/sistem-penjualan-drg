@extends('layouts.master')
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
            <h2>Edit Pelanggan </h2>
        </div>
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('pelanggan.index')}}">Pelanggan</a></li>
                <li class="breadcrumb-item"><a href="#">Edit Pelanggan</a></li>
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
        <form name="beritaForm" action="{{ route('pelanggan.update',['id' => $pelanggan->id_pelanggan]) }}"
            class="needs-validation" novalidate method="POST" enctype="multipart/form-data">

            @csrf
            <input type="hidden" name="id_pelanggan" id="id_pelanggan">

            <div class="form-group">
                <label for="nama_pelanggan">Nama :</label>
                <input type="text" class="form-control" id="nama_pelanggan" placeholder="Masukkan nama pelanggan.."
                    name="nama_pelanggan" required value="{{$pelanggan->nama_pelanggan}}" disabled=true>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field.</div>
            </div>
            <div class="form-group">
                <label for="no_hp">Nomor HP :</label>
                <input type="text" class="form-control" id="no_hp" placeholder="Masukkan no hp.." name="no_hp"
                    maxlength="13" required value="{{$pelanggan->no_hp}}" disabled=true>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field.</div>
            </div>
            <div class="form-group">
                <label for="alamat_pelanggan">Alamat :</label>
                <input type="text" class="form-control" id="alamat_pelanggan" placeholder="Masukkan alamat pelanggan.."
                    name="alamat_pelanggan" required value="{{$pelanggan->alamat_pelanggan}}" disabled=true>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field.</div>
            </div>
            <div class="form-group">
                <label for="foto_pelanggan">Upload foto pelanggan :</label> <br>
                <div class="custom-file">
                    <input type="file" class="custom-file-input form-control" id="foto_pelanggan" name="foto_pelanggan"
                        accept=".jpg,.jpeg,.png" disabled=true />
                    <label class="custom-file-label" for="foto_pelanggan">{{$pelanggan->foto_pelanggan}}</label>
                </div>
                <div>
                    <small>*Ukuran Foto Maksimal 2Mb</small>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 ">
                <img src="/gambar/pelanggan/foto-pelanggan/{{$pelanggan->foto_pelanggan}}" style="max-height: 160px;"
                    id="profile-img-tag">
            </div>

            <div class="form-group">
                <label for="foto_identitas">Upload foto identitas :</label> <br>
                <div class="custom-file">
                    <input type="file" class="custom-file-input form-control" id="foto_identitas" name="foto_identitas"
                        accept=".jpg,.jpeg,.png" disabled=true />
                    <label class="custom-file-label" for="foto_identitas">{{$pelanggan->foto_identitas}}</label>
                </div>
                <div>
                    <small>*Ukuran Foto Maksimal 2Mb</small>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 ">
                <img src="/gambar/pelanggan/foto-pelanggan/{{$pelanggan->foto_identitas}}" style="max-height: 100px;"
                    id="identitas-img-tag">
            </div>

            <div class="" style="margin-top: 30px;">
                <a href="{{route('pelanggan.index')}}" class="btn btn-danger mr-2">Batal</a>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css"
    rel="stylesheet" />
@endsection

@section('footer-script')
<script type="text/javascript">
    $('#no_hp').keypress(function (e) {
        var arr = [];
        var kk = e.which;

        for (i = 48; i < 58; i++)
            arr.push(i);

        if (!(arr.indexOf(kk) >= 0))
            e.preventDefault();
    });

    $('#foto_pelanggan').on('change', function () {
        //get the file name
        var fileName = $(this).val();
        //replace the "Choose a file" label
        $(this).next('.custom-file-label').html(fileName);
        readURL(this);

    })
    $('#foto_pelanggan').bind('change', function () {
        if (this.files[0].size / 1024 / 1024 > 2) {
            alert("Ukuran foto yang anda masukan lebih dari 2mb");
            $(this).val('');
            $(this).next('.custom-file-label').html('Masukkan foto pelanggan');
        }
    });

    $('#foto_identitas').on('change', function () {
        //get the file name
        var fileName = $(this).val();
        //replace the "Choose a file" label
        $(this).next('.custom-file-label').html(fileName);
        readURL1(this);

    })
    $('#foto_identitas').bind('change', function () {
        if (this.files[0].size / 1024 / 1024 > 2) {
            alert("Ukuran gambar yang anda masukan lebih dari 2mb");
            $(this).val('');
            $(this).next('.custom-file-label').html('Masukkan foto identitas');
        }
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            if (input.files[0].size / 1024 / 1024 < 2) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#profile-img-tag').attr('src', e.target.result);
                    document.getElementById('profile-img-tag').style.visibility = "visible";
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    }

    function readURL1(input) {
        if (input.files && input.files[0]) {
            if (input.files[0].size / 1024 / 1024 < 2) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#identitas-img-tag').attr('src', e.target.result);
                    document.getElementById('identitas-img-tag').style.visibility = "visible";
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    }

    function enableInput() {
        var inputs = document.getElementsByClassName('form-control');
        for (var i = 0; i < inputs.length; i++) {
            inputs[i].disabled = false;
        }
        $("#btnUpdate").css("display", "");
    }

    (function () {
        'use strict';
        window.addEventListener('load', function () {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function (form) {
                form.addEventListener('submit', function (event) {
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