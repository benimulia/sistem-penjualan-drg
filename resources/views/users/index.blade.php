@extends('layouts.master')
@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left mb-4">
            <h2>Users Management</h2>
        </div>
        <div class="pull-right mb-2">
            @can('user-create')
            <a class="btn btn-success" href="{{ route('users.create') }}"> Create New User</a>
            @endcan
        </div>
    </div>
</div>
@if ($message = Session::get('success'))
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="alert alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Success!</strong> {{ $message }}
            </div>
        </div>
    </div>
</div>
@endif
<table class="table table-bordered">
    <tr>
        <th>No</th>
        <th>Name</th>
        <th>Email</th>
        <th>Cabang</th>
        <th>Roles</th>
        <th width="280px">Action</th>
    </tr>
    @foreach ($data as $key => $user)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        @if(is_null($user->cabang))
        <td></td>
        @else
        <td>{{ $user->cabang->nama_cabang }}</td>
        @endif
        <td>
            @if(!empty($user->getRoleNames()))
            @foreach($user->getRoleNames() as $v)
            <span class="badge rounded-pill bg-warning">{{ $v }}</span>
            @endforeach
            @endif
        </td>
        <td>
            <a class="btn btn-info" href="{{ route('users.show',$user->id) }}">Show</a>
            <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">Edit</a>
            {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline','onsubmit' => "return ConfirmDelete()"]) !!}
            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
            {!! Form::close() !!}
        </td>
    </tr>
    @endforeach
</table>
{!! $data->render() !!}
@endsection

@section('footer-script')
<script type="text/javascript">
    var ctext = 'Confirm you want to Delete ? \n'

    function ConfirmDelete() {

        return confirm(ctext);
    };
</script>
@endsection