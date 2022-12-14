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
            <h2>Lihat Data Pembelian</h2>
        </div>
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('pembelian.index') }}">Pembelian</a></li>
                <li class="breadcrumb-item active"><a href="#">Lihat Data Pembelian</a></li>
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
        <form action="" method="POST">
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
                        <input type="text" class="form-control" id="cabang" name="cabang" value="{{$pembelian->cabang->nama_cabang}}" required disabled>
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
                                                required disabled=true style="appearance: none;">
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
                                                value="{{str_replace(".", "," , $item->qty)}}" disabled=true>
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
                                        Discount
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
        </form>
    </div>
</div>
@endsection

