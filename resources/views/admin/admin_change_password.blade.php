@extends('admin.admin_master')
@section('admin')


    <div class="intro-y flex items-center mt-8 mb-4">
        <h1 class="text-lg font-medium mr-auto">
            Change Password
        </h1>

        @if (count($errors))
            @foreach ($errors->all() as $error)
                <p class="alert alert-danger alert-dismissible fade show"> {{ $error }} </p>
            @endforeach
        @endif
    </div>

    <form method="post" action="{{ route('update.password') }}" enctype="multipart/form-data">
        @csrf

        <div> <label for="regular-form-1" class="form-label">Old Password</label> <input name="oldpassword" id="oldpassword"
                type="password" class="form-control"> </div>
        <div class="mt-3"> <label for="regular-form-1" class="form-label">New Password</label> <input name="newpassword"
                id="newpassword" type="password" class="form-control"> </div>
        <div class="mt-3"> <label for="regular-form-1" class="form-label">Confirm Password </label> <input
                name="confirm_password" id="confirm_password" type="password" class="form-control"> </div>

        <input type="submit" class="btn btn-primary waves-effect waves-light mt-6" value="Change Password">
    </form>

@endsection
