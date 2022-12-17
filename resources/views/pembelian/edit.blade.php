@extends('layouts.master')

@section('style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- Styles -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="{{asset('assets/css/select2-bootstrap-5-theme.min.css')}}" />
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
            <h2>Edit Data Pembelian</h2>
        </div>
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('pembelian.index') }}">Pembelian</a></li>
                <li class="breadcrumb-item active"><a href="#">Edit Data Pembelian</a></li>
            </ol>
        </nav>
    </div>
</div>

<div class="row" style="margin-bottom: 30px;">
    <!-- <div class="col-sm-12 col-md-12">
        <button id="btnEnableEdit" class="btn btn-info" onclick="enableInput();">Edit Data</button>
    </div> -->
</div>

<div class="row">
    <div class="col-sm-12">
        <form action="{{ route('pembelian.update',['id' => $pembelian->id_pembelian]) }}" method="POST">
            @csrf
            <input type="hidden" id="id_pembelian" name="id_pembelian">
            <div class="row">
                <div class="col-sm-6 col-md-3">
                    @if(auth()->user()->id_cabang==1)
                    <input type="hidden" name="id_cabang" value="1">
                    @elseif(auth()->user()->id_cabang==2)
                    <input type="hidden" name="id_cabang" value="2">
                    @elseif(auth()->user()->id_cabang==3)
                    <input type="hidden" name="id_cabang" value="3">
                    @else
                    <div class="form-group">
                        <label for="id_cabang">Cabang :</label>
                        <div class="w-100"></div>
                        <select class="form-control" name="id_cabang" required disabled=true>
                            <option value="">Pilih Cabang</option>
                            @foreach($cabang as $result)
                            <option value="{{$result->id_cabang}}" {{ ($pembelian->
                                id_cabang==$result->id_cabang)?"selected" : "" }}>{{$result->nama_cabang}}</option>
                            @endforeach
                        </select>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Please fill out this field.
                        </div>
                    </div>
                    @endif
                </div>

                <div class="col-sm-6 col-md-3">
                    <div class="form-group">
                        <label for="tgl_pembelian">Tanggal Pembelian :</label>
                        <input class="datepicker form-control px-2" type="text" id="tgl_pembelian" name="tgl_pembelian"
                            placeholder="Masukkan tanggal pembelian.." required value="{{$pembelian->tgl_pembelian}}"
                            disabled=true>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Please fill out this field.
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-3">
                    <div class="form-group">
                        <label for="supplier">Supplier :</label>
                        <input type="text" class="form-control" id="supplier" placeholder="Masukkan nama supplier.."
                            name="supplier" required value="{{$pembelian->supplier}}" disabled=true>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Please fill out this field.
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3"></div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="table-responsive">
                        <table class="table table-hover table-white" id="tabelPembelian">
                            <thead>
                                <tr>
                                    <th style="width: 20px">#</th>
                                    <th class="col-sm-6">Produk</th>
                                    <th style="width:100px;">Qty</th>
                                    <th style="width:150px;">Harga</th>
                                    <th style="width:200px">Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pembelianJoin as $key => $item)
                                <tr>
                                    <input type="hidden" name="id_pembelian_detail[]" id="id_pembelian"
                                        value="{{$item->id_pembelian_detail}}">
                                    <td hidden class="ids">{{ $item->id_pembelian_detail }}</td>
                                    <td>{{++$key}}</td>
                                    <td>
                                        <div class="form-group">
                                            <select class="form-control" name="id_produk[]"
                                                required disabled=true>
                                                <option value="">Pilih Produk</option>
                                                @foreach ($produk as $index => $result)
                                                <option value="{{$result->id_produk}}" {{ ($item->
                                                    id_produk==$result->id_produk)?"selected" : "" }}>
                                                    {{$result->nama_produk}}</option>
                                                @endforeach
                                            </select>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                Please fill out this field.
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" class="form-control qty" id="qty" placeholder="Qty"
                                                maxlength="5" name="qty[]" required style="min-width:100px"
                                                value="{{$item->qty}}" disabled=true>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                Please fill out this field.
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <div class="d-flex">
                                                <span class="prefix mr-2 mt-0">Rp</span>
                                                <input type="text" class="form-control harga" id="harga"
                                                    placeholder="Harga" maxlength="20" name="harga[]" required
                                                    style="min-width:150px" value="{{$item->harga}}" disabled=true>
                                            </div>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                Please fill out this field.
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <span class="prefix mr-2 mt-0">Rp</span>

                                            <input class="form-control sub_total" style="width:200px" type="text"
                                                id="subtotal" name="subtotal[]" readonly value="{{$item->subtotal}}">
                                        </div>
                                    </td>
                                    <!-- @if($item->id_pembelian_detail ==!null)
                                    <td><a class="text-danger font-18 delete_pembelian_detail" href="#"
                                            data-toggle="modal" data-target="#delete_pembelian_detail" title="Remove"><i
                                                class="fa fa-trash"></i></a></td>
                                    @else
                                    <td><a class="text-danger font-18 remove" href="#" title="Remove"><i
                                                class="fa fa-trash"></i></a></td>
                                    @endif

                                    @if($key =='1')
                                    <td><a href="javascript:void(0)" class="text-success font-18" title="Add"
                                            id="addBtn"><i class="fa fa-plus"></i></a></td>
                                    @endif -->

                                </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-white">
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-right">Total</td>
                                    <td>
                                        <div class="d-flex">
                                            <span class="prefix mr-2 mt-0">Rp</span>
                                            <input class="form-control text-right sum_total" type="text" id="sum_total"
                                                name="sum_total" value="{{$pembelian->total_pembelian}}" readonly>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right">Tax</td>
                                    <td>
                                        <input class="form-control text-right" type="text" id="tax_1" name="tax_1"
                                            value="0" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right">
                                        Discount %
                                    </td>
                                    <td>
                                        <input class="form-control text-right discount" type="text" id="discount"
                                            name="discount" value="0" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" style="text-align: right; font-weight: bold">
                                        Grand Total
                                    </td>
                                    <td style="font-size: 16px;width: 230px">
                                        <div class="d-flex">
                                            <span class="prefix mr-2 mt-0">Rp</span>
                                            <input class="form-control text-right" type="text" id="total" name="total"
                                                value="{{$pembelian->total_pembelian}}" readonly>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Keterangan</label>
                                <textarea class="form-control" rows="3" id="keterangan" name="keterangan" disabled=true>{{$pembelian->keterangan}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="submit-section">
                <a href="{{route('pembelian.index')}}" class="btn btn-danger mr-2">Cancel</a>
                <button type="submit" class="btn btn-primary submit-btn">Submit</button>
            </div> -->
        </form>
    </div>
    <!-- Delete Estimate Modal -->
    <div class="modal custom-modal fade" id="delete_pembelian_detail" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning dark">
                    <h5 class="modal-title w-100 text-dark">Hapus Data?</h5>

                    <a data-dismiss="modal" class="btn btn-secondary btn-circle">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
                <form action="{{ route('pembelian.index') }}" method="GET">
                    @csrf
                    <div class="modal-body">
                        <p>Apakah anda yakin untuk menghapus data? Data yang sudah dihapus tidak dapat kembali!</p>
                        <small>Stok produk juga akan berkurang sesuai yang tertera dalam pembelian</small>

                        <input type="hidden" name="id" class="e_id" value="">

                    </div>
                    <div class="modal-footer">
                        <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                        <button type="submit" class="btn btn-danger continue-btn submit-btn">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Delete Estimate Modal -->
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
{{-- add multiple row --}}
<script type="text/javascript">

    var rowIdx = 1;
    $("#addBtn").on("click", function () {
        // Adding a row inside the tbody.
        $("#tabelPembelian tbody").append(`
                <tr id="R${++rowIdx}">
                    <td class="row-index text-center"><p> ${rowIdx}</p></td>
                    <td>
                                        <div class="form-group">
                                            <select class="form-control select2 produk" id="produk" name="id_produk[]"
                                                required>
                                                <option value="">Pilih Produk</option>
                                                @foreach ($produk as $index => $result)
                                                <option value="{{$result->id_produk}}">{{$result->nama_produk}}</option>
                                                @endforeach
                                            </select>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                Please fill out this field.
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" class="form-control qty" id="qty" placeholder="Qty"
                                                maxlength="5" name="qty[]" required style="min-width:100px">
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                Please fill out this field.
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <div class="d-flex">
                                                <span class="prefix mr-2 mt-0">Rp</span>
                                                <input type="text" class="form-control harga" id="harga" placeholder="Harga"
                                                maxlength="20" name="harga[]" required style="min-width:150px">
                                            </div>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                Please fill out this field.
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <span class="prefix mr-2 mt-0">Rp</span>
                                            <input class="form-control sub_total" style="width:200px" type="text" id="subtotal"
                                            name="subtotal[]" value="0" readonly>
                                        </div>
                                    </td>
                    <td><a href="javascript:void(0)" class="text-danger font-18 remove" title="Remove"><i class="fa fa-trash"></i></a></td>
                </tr>`);
        $('.produk').select2({
            placeholder: "Pilih Produk",
            allowClear: true,
            theme: "bootstrap-5",
        });
    });
    $("#tabelPembelian tbody").on("click", ".remove", function () {
        // Getting all the rows next to the row
        // containing the clicked button
        var child = $(this).closest("tr").nextAll();
        // Iterating across all the rows
        // obtained to change the index
        child.each(function () {
            // Getting <tr> id.
            var id = $(this).attr("id");

            // Getting the <p> inside the .row-index class.
            var idx = $(this).children(".row-index").children("p");

            // Gets the row number from <tr> id.
            var dig = parseInt(id.substring(1));

            // Modifying row index.
            idx.html(`${dig - 1}`);

            // Modifying row id.
            $(this).attr("id", `R${dig - 1}`);
        });

        // Removing the current row.
        $(this).closest("tr").remove();

        // Decreasing total number of rows by 1.
        rowIdx--;

        $('.produk').select2({
            placeholder: "Pilih Produk",
            allowClear: true,
            theme: "bootstrap-5",
        });
    });

    $("#tabelPembelian tbody").on("input", ".harga", function () {
        var harga = parseFloat($(this).val());
        var qty = parseFloat($(this).closest("tr").find(".qty").val());
        var subtotal = $(this).closest("tr").find(".sub_total");
        subtotal.val(harga * qty);

        calc_total();
    });

    $("#tabelPembelian tbody").on("input", ".qty", function () {
        var qty = parseFloat($(this).val());
        var harga = parseFloat($(this).closest("tr").find(".harga").val());
        var subtotal = $(this).closest("tr").find(".sub_total");
        subtotal.val(harga * qty);
        calc_total();
    });

    function calc_total() {
        var sum = 0;
        $(".sub_total").each(function () {
            sum += parseFloat($(this).val());
        });

        $("#sum_total").val(new Intl.NumberFormat('id-ID').format(sum));
        $("#total").val(new Intl.NumberFormat('id-ID').format(sum));

    }

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
        endDate: new Date(new Date().setDate(new Date().getDate()))
    });

    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });

    $(document).ready(function () {
        $('#id_cabang').select2({
            placeholder: "Pilih Cabang",
            allowClear: true,
            theme: "bootstrap-5",
        });
        $('.produk').select2({
            placeholder: "Pilih Produk",
            allowClear: true,
            theme: "bootstrap-5",
        });
    });

    (function () {
        'use strict';
        window.addEventListener('load', function () {
            var forms = document.getElementsByClassName('needs-validation');
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

    $('#qty').keypress(function (e) {
        var arr = [];
        var kk = e.which;

        for (i = 48; i < 58; i++)
            arr.push(i);

        if (!(arr.indexOf(kk) >= 0))
            e.preventDefault();
    });

    $('#harga').keypress(function (e) {
        var arr = [];
        var kk = e.which;

        for (i = 48; i < 58; i++)
            arr.push(i);

        if (!(arr.indexOf(kk) >= 0))
            e.preventDefault();
    });


    // var rupiah = document.getElementById("harga");
    // rupiah.addEventListener("keyup", function (e) {
    //     // tambahkan 'Rp.' pada saat form di ketik
    //     // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
    //      rupiah.valu        e = formatRupiah(this.v        al ue, "Rp. ");
    // });

    // /* Fungsi formatRu        piah */
    // fu        nction formatRupiah( angka, prefix) {
              //     var                 mber_string = angka.                place(/[^,\d]/g, "").toString(),
    //                                   split = number_string.split(","),
    //         sisa = split[0].length % 3,
    //         rupiah = split[0].substr(0, sisa),
    //         ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    //     // tambahkan titik jika yang di input sudah menjadi angka ribuan
    //     if (ribuan) {
    //         separator = sisa ? "." : "";
    //         rupiah += separator + ribuan.join(".");
    //     }

    //     rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
    //     return prefix == un? rupiah : rupiah ? "Rp. " + rupiah : "";
    // }

</script>
@endsection