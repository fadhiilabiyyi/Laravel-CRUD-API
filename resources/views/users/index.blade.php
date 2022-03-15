@extends('layouts.dashboard')

@section('container')

<div class="table-responsive col-lg-10 container">
    <h1 class="h2 mt-3 text-start">{{ $title }}</h1>

    <a href="{{ route('user.create') }}" class="btn btn-primary my-3">Create New User</a>

    @if (session()->has('success'))
        <div class="alert alert-success align-center alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif (session()->has('failed'))
        <div class="alert alert-danger align-center alert-dismissible fade show" role="alert">
            {{ session('failed') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif



    <table class="table table-hover table-bordered align-center text-center">
        <thead>
            <tr>
                <th>No</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($datas as $user)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $user['firstName'] }}</td>
                <td>{{ $user['lastName'] }}</td>
                <td>
                    <a href="{{ route('user.show', $user['id']) }}" class="badge bg-warning"><i class="fa fa-fw fa-edit"></i></a>

                    <form method="POST" action="{{ 'user/'.$user['id'] }}" class="d-inline">
                        @method('DELETE')
                        @csrf
                        
                        <button type="submit" class="badge bg-danger border-0" onClick="return confirm('Are you sure to delete this user?');"><i class="fa fa-fw fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No Record(s) Found!</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection