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
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('cabang.index')}}">Cabang</a></li>
                <li class="breadcrumb-item"><a href="#">Edit Cabang</a></li>
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
        <form name="beritaForm" action="{{ route('cabang.update',['id' => $cabang->id_cabang]) }}" class="needs-validation" novalidate method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_cabang" id="id_cabang">
            @csrf
            <div class="form-group">
                <label for="nama_cabang">Nama Cabang :</label>
                <input type="text" class="form-control" id="nama_cabang" placeholder="Masukkan nama cabang.." name="nama_cabang" required value="{{$cabang->nama_cabang}}" disabled=true>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field.</div>
            </div>
            <div class="form-group">
                <label for="kategori">Kategori :</label>
                <div class="w-100"></div>
                <select class="form-control" id="kategori" name="kategori" disabled=true required>
                    <option value="Pakan" {{ ($cabang->kategori=="Pakan")? "selected" : "" }} >Pakan</option>
                    <option value="Telur" {{ ($cabang->kategori=="Telur")? "selected" : "" }} >Telur</option>
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
                <input type="text" class="form-control" id="alamat_cabang" placeholder="Masukkan alamat cabang.." name="alamat_cabang" required value="{{$cabang->alamat_cabang}}" disabled=true>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field.</div>
            </div>
            <div class="form-group">
                <label for="tgl_buka">Tanggal Buka Cabang :</label>
                <input class="datepicker form-control" type="text" id="tgl_buka" name="tgl_buka" placeholder="Masukkan tanggal buka cabang.." required value="{{$cabang->tgl_buka}}" disabled=true>
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    Please fill out this field.
                </div>
            </div>

            <div class="" style="margin-top: 30px;">
                <a href="{{route('cabang.index')}}" class="btn btn-danger mr-2">Cancel</a>
                <a href="#myModal" id="btnUpdate" data-toggle="modal" class="btn btn-success" style="display: none;">Update </a>
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

    function enableInput() {
        var inputs = document.getElementsByClassName('form-control');
        for (var i = 0; i < inputs.length; i++) {
            inputs[i].disabled = false;
        }
        $("#btnUpdate").css("display", "");
        $("#btnEnableEdit").css("display", "none");
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