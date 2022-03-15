@extends('layouts.dashboard')

@section('container')

<div class="container col-lg-10 my-3">

    <h1 class="h2 mt-3 text-start">{{ $title }}</h1>

    <form method="POST" action="{{ route('user.store') }}" autocomplete="off" class="align-center">
        @csrf
        <div class="mb-3">
            <label for="firstName" class="form-label">First Name</label>
            <input type="text" name="firstName" class="form-control" id="firstName" required>
        </div>
        <div class="mb-3">
            <label for="lastName" class="form-label">Last Name</label>
            <input type="text" name="lastName" class="form-control" id="lastName" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="email" required>
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>    
</div>

@endsection