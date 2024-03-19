@extends('admin.admin_master')
@section('admin')
    <div class="intro-y flex items-center mt-8 mb-4">
        <h1 class="text-lg font-medium mr-auto">
            Change Password
        </h1>

    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script> <!-- Include jQuery Validation plugin -->
    <form method="post" action="{{ route('update.password') }}" enctype="multipart/form-data" id="myForm">
        @csrf

        <div> <label for="regular-form-1" class="form-label">Old Password</label>
            <input name="oldpassword" id="oldpassword" type="password" class="form-control"
                placeholder="Masukkan Old Password">
        </div>
        <div class="mt-3"> <label for="regular-form-1" class="form-label">New Password</label>
            <input name="newpassword" id="newpassword" type="password" class="form-control"
                placeholder="Masukkan New Password">
        </div>
        <div class="mt-3"> <label for="regular-form-1" class="form-label">Confirm Password </label>
            <input name="confirm_password" id="confirm_password" type="password" class="form-control"
                placeholder="Masukkan Confirm Password">
        </div>

        <div class="mt-4">
             <a href="{{ route('admin.profile') }}" class="btn btn-danger w-full h-10 xl:w-32 xl:mr-2 align-top"
                type="submit">Cancel</a>
            <button class="btn btn-primary  w-full  h-10 xl:w-32 xl:mr-3 align-top" type="submit">Save </button>
           
        </div>
    </form>


    <script type="text/javascript">
        jQuery(document).ready(function() {
            $('#myForm').validate({
                rules: {
                    oldpassword: {
                        required: true,
                    },
                    newpassword: {
                        required: true,
                    },
                    confirm_password: {
                        required: true,
                    },
                },
                messages: {
                    oldpassword: {
                        required: 'Please Enter Your oldpassword',
                    },
                    newpassword: {
                        required: 'Please Enter Your newpassword',
                    },
                    confirm_password: {
                        required: 'Please Enter Your confirm_password',
                    },

                },
                errorElement: 'span',
                errorClass: 'invalid-feedback',
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
            });
        });
    </script>
@endsection
