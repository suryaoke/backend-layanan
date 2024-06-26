@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <div class="intro-y flex items-center mt-8 mb-4">
        <h1 class="text-lg font-medium mr-auto">
            Edit Profile User
        </h1>
    </div>

    <form method="post" action="{{ route('store.profile') }}" enctype="multipart/form-data">
        @csrf

        <div> <label for="regular-form-1" class="form-label">Name</label> <input name="name" id="regular-form-1"
                type="text" class="form-control" value="{{ $editData->name }}"> </div>
        <div class="mt-3"> <label for="regular-form-1" class="form-label">User Email</label> <input name="email"
                id="regular-form-1" type="text" class="form-control" value="{{ $editData->email }}"> </div>
        <div class="mt-3"> <label for="regular-form-1" class="form-label">User Name</label> <input name="username"
                id="regular-form-1" type="text" class="form-control" value="{{ $editData->username }}"> </div>


        <div class="mt-3 flex"> <label for="regular-form-1" class="mr-2">Profile Image</label> <input name="profile_image"
                type="file" id="image">
        </div>


        <div class="mt-3 flex ">
            <img width="130px auto" id="showImage"
                src="{{ !empty($editData->profile_image) ? url('uploads/admin_images/' . $editData->profile_image) : url('uploads/no_image.jpg') }}"
                alt="Card image cap">
        </div>


        <div class="mt-8">
              <a href="{{ route('admin.profile') }}" class="btn btn-danger w-full h-10 xl:w-32 xl:mr-2 align-top"
                type="submit">Cancel</a>
            <button class="btn btn-primary  w-full  h-10 xl:w-32 xl:mr-3 align-top" type="submit">Save </button>
          
        </div>
    </form>



    <script type="text/javascript">
        $(document).ready(function() {
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>


    <script type="text/javascript">
        $(document).ready(function() {
            $('#ttd').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage1').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>
@endsection
