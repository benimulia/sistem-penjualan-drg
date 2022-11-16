@extends('layouts.master')

@section('content')
<!-- Content Row -->
<div class="row">
    <!-- Area Chart -->
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Dashboard</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif

                {{ __('You are logged in!') }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<!-- Page level plugins -->
<script src="{{ asset('admin/vendor/chart.js/Chart.min.js')}}"></script>

<!-- Page level custom scripts -->
<script src="{{ asset('admin/js/demo/chart-area-demo.js')}}"></script>
<script src="{{ asset('admin/js/demo/chart-pie-demo.js')}}"></script>
@endsection