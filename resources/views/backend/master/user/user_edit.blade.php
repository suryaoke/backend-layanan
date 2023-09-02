@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <div class="intro-y flex editDatas-center mt-8 mb-4">
        <h1 class="text-lg font-medium mr-auto">
            Edit Profile User
        </h1>
    </div>

    <form method="post" action="{{ route('user.update') }}" id="myForm" enctype="multipart/form-data">
        @csrf
        <div> <input name="id" id="regular-form-1" type="hidden" class="form-control" value="{{ $editData->id }}"> </div>

        <div> <label for="regular-form-1" class="form-label">Name</label> <input name="name" id="regular-form-1"
                type="text" class="form-control" value="{{ $editData->name }}"> </div>
        <div class="mt-3"> <label for="regular-form-1" class="form-label">User Email</label> <input name="email"
                id="regular-form-1" type="text" class="form-control" value="{{ $editData->email }}"> </div>
        <div class="mt-3"> <label for="regular-form-1" class="form-label">User Name</label> <input name="username"
                id="regular-form-1" type="text" class="form-control" value="{{ $editData->username }}"> </div>
        <div class="mt-3"> <label for="regular-form-1" class="form-label">Jabatan</label>

            <select name="jabatan" data-placeholder="Select Jabatan" id="jabatan" class="tom-select w-full  mt-2 "
                aria-label="Default select example">
                <option value="{{ $editData->jabatan }}">
                    @php
                        $jabatans = App\Models\Jabatan::where('id', $editData->jabatan)->get();
                    @endphp
                    @foreach ($jabatans as $jbts)
                    @endforeach

                    {{ $jbts->name }}

                </option>
                @foreach ($jabatan as $jbt)
                    <option value=" {{ $jbt->id }} ">{{ $jbt->name }} </option>
                @endforeach
            </select>

        </div>
        <div class="mt-3">
            <label for="regular-form-1" class="form-control">Role</label>
            <select name="role" id="role" data-placeholder="Select Role" class="tom-select w-full  mt-2 ">
                <option value="{{ $editData->role }}">

                    @if ($editData->role == '-')
                        Tidak Aktif
                    @elseif($editData->role == '0')
                        Belum Dipilih
                    @elseif($editData->role == '1')
                        Kepsek
                    @elseif($editData->role == '2')
                        Wakil Kepsek
                    @elseif($editData->role == '3')
                        Verifikator
                    @elseif($editData->role == '4')
                        Admin
                    @endif
                </option>

                <option value="-">Tidak Aktif</option>
                <option value="1">Kepsek</option>
                <option value="2">Wakil Kepsek</option>
                <option value="3">Verifikator</option>
                <option value="4">Admin</option>
            </select>
        </div>


        <div class="mt-3 flex">

            <label for="regular-form-1" class="mr-2">Profile Image</label> <input name="profile_image" type="file"
                id="image">

            @if ($editData->role == '1')
                <label for="regular-form-1" class="mr-2">Ttd Image</label> <input name="ttd" type="file"
                    id="ttd">
            @endif

        </div>

        <div class="mt-3 flex ">
            <img width="130px auto" id="showImage"
                src="{{ !empty($editData->profile_image) ? url('uploads/admin_images/' . $editData->profile_image) : url('uploads/no_image.jpg') }}"
                alt="Card image cap">
            @if ($editData->role == '1')
                <div class="ml-8">

                    <img width="130px auto" id="showImage1"
                        src="{{ !empty($editData->ttd) ? url('uploads/ttd/' . $editData->ttd) : url('uploads/no_image.jpg') }}"
                        alt="Card image cap">
                </div>
            @endif
        </div>

        <input type="submit" name="profile_image" class="btn btn-primary waves-effect waves-light mt-6"
            value="Update User">


    </form>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#myForm').validate({
                rules: {
                    name: {
                        required: true,
                    },
                    email: {
                        required: true,
                    },
                    username: {
                        required: true,
                    },
                    role: {
                        required: true,
                    },
                    jabatan: {
                        required: true,
                    },
                    ttd: {
                        required: true,
                    },
                    image: {
                        required: true,
                    },

                },
                messages: {
                    name: {
                        required: 'Please Enter Your Name',
                    },
                    email: {
                        required: 'Please Enter Your Email',
                    },
                    username: {
                        required: 'Please Enter Your Username',
                    },
                    role: {
                        required: 'Please Enter Your Role',
                    },
                    jabatan: {
                        required: 'Please Enter Your Jabatan',
                    },
                    ttd: {
                        required: 'Please Enter Your Jabatan',
                    },
                    image: {
                        required: 'Please Enter Your Jabatan',
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
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
