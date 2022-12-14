@extends('layouts.master')

@section('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
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
            <h2>Tambah Penjualan Baru - {{$tglhariini}}</h2>
        </div>
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('penjualan.index') }}">Penjualan</a></li>
                <li class="breadcrumb-item active"><a href="#">Tambah Penjualan Baru</a></li>
            </ol>
        </nav>
    </div>
</div>


<div class="row">
    <div class="col-sm-12">
        <form action="{{ route('penjualan.store') }}" method="POST" autocomplete="off">
            @csrf
            <div class="row">
                <div class="col-sm-6 col-md-3">
                    @if (auth()->user()->id_cabang == 0)
                    <div class="form-group">
                        <label for="id_cabang">Cabang :</label>
                        <div class="w-100"></div>
                        <select class="form-control select2" id="id_cabang" name="id_cabang" required>
                            <option value="">Pilih Cabang</option>
                            @foreach ($cabang as $result)
                                <option value="{{ $result->id_cabang }}">{{ $result->nama_cabang }}</option>
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
                </div>

                <div class="col-sm-6 col-md-3">
                    <div class="form-group">
                        <label for="tgl_penjualan">Tanggal Penjualan :</label>
                        <input class="datepicker form-control px-2" type="text" id="tgl_penjualan" name="tgl_penjualan"
                            placeholder="Masukkan tanggal penjualan.." required>
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
                        <label for="id_pelanggan">Pelanggan:</label>
                        <select class="form-control select2 pelanggan" id="id_pelanggan" name="id_pelanggan">
                            <option value="">Pelanggan</option>
                            @foreach ($pelanggan as $index => $result)
                            <option value="{{$result->id_pelanggan}}">{{$result->nama_pelanggan}}</option>
                            @endforeach
                        </select>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Please fill out this field.
                        </div>
                        <small>*tidak wajib diisi</small>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    
                </div>
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
                                    <th style="width:200px;">Harga</th>
                                    <th style="width:200px">Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>
                                        <div class="form-group">
                                            <select class="form-control select2 produk" id="produk" name="id_produk[]"
                                                required>
                                                <option value="">Pilih Produk</option>
                                                @foreach ($produk as $index => $result)
                                                <option value="{{$result->id_produk}}">{{$result->nama_produk}} - {{$result->satuan}}</option>
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
                                        <div class="form-group" style="width:200px;">
                                        <div class="d-flex">
                                            <span class="prefix mr-2 mt-0">Rp</span>
                                            <select class="form-control harga" id="harga-dropdown" name="harga[]">
                                            </select>
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
                                                id="subtotal" name="subtotal[]" value="0" readonly>
                                        </div>
                                    </td>
                                    
                                    <input class="satuan" type="hidden" name="satuan[]" id="satuan">

                                    <td><a href="javascript:void(0)" class="text-success font-18" title="Add"
                                            id="addBtn"><i class="fa fa-plus"></i></a></td>
                                </tr>
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
                                                name="sum_total" value="0" readonly>
                                        </div>
                                    </td>
                                </tr>
                                <!-- <tr>
                                    <td colspan="5" class="text-right">Tax</td>
                                    <td>
                                        <input class="form-control text-right" type="text" id="tax_1" name="tax_1"
                                            value="0" readonly>
                                    </td>
                                </tr> -->
                                <tr>
                                    <td colspan="5" class="text-right">
                                        Discount
                                    </td>
                                    <td>
                                        <input class="form-control text-right discount" type="text" id="discount"
                                            name="discount" value="0" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right"></td>
                                    <td>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right">Jumlah Bayar</td>
                                    <td>
                                        <input class="form-control text-right" type="text" id="jumlah_bayar" name="jumlah_bayar" required>
                                    </td>
                                </tr>
                                <tr class="bg-success text-white">
                                    <td colspan="5" style="text-align: right; font-weight: bold">
                                        Grand Total
                                    </td>
                                    <td style="font-size: 16px;width: 230px">
                                        <div class="d-flex">
                                            <span class="prefix mr-2 mt-0">Rp</span>
                                            <input class="form-control text-right" type="text" id="total" name="total"
                                                value="0" readonly>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right">Kembali</td>
                                    <td>
                                        <input class="form-control text-right" type="text" id="kembalian" name="kembalian" readonly>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Keterangan</label>
                                <textarea class="form-control" rows="3" id="keterangan" name="keterangan"></textarea>
                                <small>*tidak wajib diisi</small>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="submit-section">
                <a href="{{route('penjualan.index')}}" class="btn btn-danger mr-2">Batal</a>
                <a class="btn btn-primary submit-btn" href="#" data-toggle="modal" data-target="#submit-penjualan"
                    title="Submit">Submit</a>
            </div>

            <!-- Submit Pembelian Modal -->
            <div class="modal custom-modal fade" id="submit-penjualan" role="dialog">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title w-100 text-dark">Submit Data?</h5>

                            <a data-dismiss="modal" class="btn btn-secondary btn-circle">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>

                        <div class="modal-body">
                            <p>Apakah anda yakin untuk submit data? Data penjualan yang sudah terbuat tidak dapat diubah!</p>
                            <small>Stok produk akan berkurang sesuai yang tertera dalam penjualan</small>
                        </div>

                        <div class="modal-footer">
                            <a href="javascript:void(0);" data-dismiss="modal"
                                class="btn btn-secondary cancel-btn">Batal</a>
                            <button type="submit" class="btn btn-success continue-btn submit-btn">Ya, submit</button>
                        </div>

                    </div>
                </div>
            </div>
            <!-- Submit Pembelian Modal -->
        </form>
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
                                                <option value="{{$result->id_produk}}">{{$result->nama_produk}} - {{$result->satuan}}</option>
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
                                        <div class="form-group" style="width:200px;">
                                        <div class="d-flex">
                                            <span class="prefix mr-2 mt-0">Rp</span>
                                            <select class="form-control harga" id="harga-dropdown" name="harga[]">
                                            </select>
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
                                    <input class="satuan" type="hidden" name="satuan[]" id="satuan">
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

        calc_total();
    });

    $("#tabelPembelian tbody").on("change", ".produk", function () {
        if($(this).val() != ''){            
            var id_produk = $(this).val()
            
            $.ajax({
                context: this,
                url: "{{route('penjualan.fetch') }}",
                method : "POST",
                data : 
                {
                    id_produk:id_produk,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success:function(result){
                    $(this).closest("tr").find(".harga").html('<option value="' + result.produk[0].harga_cash + '">' + result.produk[0].harga_cash + '</option>');
                    $(this).closest("tr").find(".harga").append('<option value="' + result.produk[0].harga_bon + '">' + "Bon: " + result.produk[0].harga_bon + '</option>');

                    var harga = parseFloat($(this).closest("tr").find(".harga").val());
                    var qty = parseFloat($(this).closest("tr").find(".qty").val());
                    var subtotal = $(this).closest("tr").find(".sub_total");
                    subtotal.val(harga * qty);
                    calc_total();

                    var satuan = $(this).closest("tr").find(".satuan");
                    satuan.val(result.produk[0].satuan);
                }
            })
        }
        
    });

    $("#tabelPembelian tbody").on("input", ".harga", function () {
        var harga = parseFloat($(this).val());
        var qty = parseFloat($(this).closest("tr").find(".qty").val().replaceAll(',', '.'));
        var subtotal = $(this).closest("tr").find(".sub_total");
        subtotal.val(harga * qty);

        calc_total();
        calc_kembalian();
    });

    $("#tabelPembelian tbody").on("input", ".qty", function () {
        var qty = parseFloat($(this).val().replaceAll(',', '.'));
        var harga = parseFloat($(this).closest("tr").find(".harga").val());
        var subtotal = $(this).closest("tr").find(".sub_total");
        subtotal.val(harga * qty);
        calc_total();
        calc_kembalian();
    });

    function calc_total() {
        var sum = 0;

        $(".sub_total").each(function () {
            sum += parseFloat($(this).val());
        });

        $("#sum_total").val(new Intl.NumberFormat('id-ID').format(sum));
        $("#total").val(new Intl.NumberFormat('id-ID').format(sum));

    }

    function getTanggal() {
        var today = new Date();
        var dd = today.getDate();

        var mm = today.getMonth()+1; 
        var yyyy = today.getFullYear();
        if(dd<10) 
        {
            dd='0'+dd;
        } 

        if(mm<10) 
        {
            mm='0'+mm;
        } 

        return today = yyyy+'-'+mm+'-'+dd;

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
        document.getElementById('tgl_penjualan').value=getTanggal();

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

        $('.pelanggan').select2({
            placeholder: "Pilih Pelanggan",
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
        var charCode = (e.which) ? e.which : e.keyCode
	    if (charCode === 44){
		    return true;
	    }else if ( charCode > 31 && (charCode < 48 || charCode > 57) ){
		    return false;
	    }
	    return true;
    });

    $('#harga').keypress(function (e) {
        var arr = [];
        var kk = e.which;

        for (i = 48; i < 58; i++)
            arr.push(i);

        if (!(arr.indexOf(kk) >= 0))
            e.preventDefault();
    });

    $("#jumlah_bayar").on("keyup", function(event) {                   
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
    input = input?parseInt(input, 10):0; 
    $this.val(function () {
        return (input === 0)?"0":input.toLocaleString("id-ID"); 
    }); 
    }); 

    function calc_kembalian() {
        var total = $("#total").val().replaceAll('.', '');
        var bayar = $("#jumlah_bayar").val().replaceAll('.', '');
        
        var kembalian = $("#kembalian");
        kembalian.val(bayar-total);

        // Get the value.
        var input = kembalian.val();            
        input = input.replace(/[\D\s\._\-]+/g, ""); 
        input = input?parseInt(input, 10):0; 
        kembalian.val(function () {
            if(kembalian.val() < 0){
                return (input === 0)?"0":"-" + input.toLocaleString("id-ID"); 
            }else{
                return (input === 0)?"0":input.toLocaleString("id-ID"); 
            }
            
        }); 
    }

    $("#jumlah_bayar").on("input", function () {
        calc_kembalian();
    });

</script>
@endsection