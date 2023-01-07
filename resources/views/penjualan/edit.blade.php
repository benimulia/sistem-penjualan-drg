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
            <h2>Lihat Data Penjualan</h2>
        </div>
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('penjualan.index') }}">Penjualan</a></li>
                <li class="breadcrumb-item active"><a href="#">Lihat Data Penjualan</a></li>
            </ol>
        </nav>
    </div>
</div>


<div class="row">
    <div class="col-sm-12">
        <form action="" method="POST" autocomplete="off">
            @csrf
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
                        <input type="text" class="form-control" id="cabang" name="cabang" value="{{$penjualan->cabang->nama_cabang}}" required disabled>
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
                        <label for="tgl_penjualan">Tanggal Penjualan :</label>
                        <input class="datepicker form-control px-2" type="text" id="tgl_penjualan" name="tgl_penjualan"
                            value="{{date('Y-m-d', strtotime($penjualan->tgl_penjualan) )}}" required disabled>
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
                        <input type="text" class="form-control" id="pelanggan" name="pelanggan" value="{{$penjualan->pelanggan->nama_pelanggan}}" required disabled>
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
                        <table class="table table-hover table-white" id="tabelPenjualan">
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
                            @foreach($penjualanJoin as $key => $item)
                                <tr>
                                    <td style="wi">{{++$key}}</td>
                                    <td>
                                        <div class="form-group">
                                            <select class="form-control select2 produk" id="produk" name="id_produk[]"
                                                required disabled style="appearance: none;">
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
                                                maxlength="5" name="qty[]" value="{{str_replace(".", "," , $item->qty)}}" required style="min-width:100px" disabled>
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
                                            <input style="min-width:150px" class="form-control harga" id="harga-dropdown" name="harga[]" value="{{number_format($item->harga,0,',','.') }}" disabled>
                                            </inpui>
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
                                                id="subtotal" name="subtotal[]" value="{{number_format($item->subtotal,0,',','.') }}" disabled>
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
                                                name="sum_total" value="{{number_format($penjualan->total_penjualan,0,',','.') }}" disabled>
                                        </div>
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
                                    <td colspan="5" class="text-right"></td>
                                    <td>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right">Jumlah Bayar</td>
                                    <td>
                                        <input class="form-control text-right" type="text" id="jumlah_bayar" name="jumlah_bayar" value="{{number_format($penjualan->jumlah_bayar,0,',','.') }}" disabled>
                                    </td>
                                </tr>
                                <tr class="text-white">
                                    <td colspan="5" style="text-align: right; font-weight: bold">
                                     
                                    </td>
                                    <td style="font-size: 16px;width: 230px">
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right"></td>
                                    <td>
                                        
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Keterangan</label>
                                <textarea class="form-control" rows="3" id="keterangan" name="keterangan" disabled>{{$penjualan->keterangan}}</textarea>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
           
            
        </form>
    </div>
</div>
@endsection

