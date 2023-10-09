@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <div class="intro-y flex items-center mt-8 mb-4">
        <h1 class="text-lg font-medium mr-auto">
            Edit Pengampu
        </h1>
    </div>

    <form method="post" action="{{ route('pengampu.update') }}" enctype="multipart/form-data" id="myForm">
        @csrf

        <input type="hidden" name="id" value="{{ $pengampu->id }}">
        <div class="mt-4">
            <label for=""> Guru</label>
            <select name="id_guru" id="id_guru" class="tom-select w-full" required>
                <option value="{{ $pengampu->id_guru }}">{{ $pengampu['gurus']['nama'] }}</option>
                @foreach ($guru as $item)
                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mt-4">
            <label for=""> Mata Pelajaran</label>
            <select name="id_mapel" id="id_mapel" class="tom-select w-full" required>
                <option value="{{ $pengampu->id_mapel }}">{{ $pengampu['mapels']['nama'] }}</option>
                @foreach ($mapel as $item)
                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mt-4">
            <label for=""> Kelas</label>
            <select name="kelas" id="kelas" class="tom-select w-full mt-1" required>
                <option value="{{ $pengampu->kelas }}">{{ $pengampu['kelass']['nama'] }}</option>
                @foreach ($kelas as $item)
                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mt-4">
            <label for=""> Kurikulum</label>
            <input type="text" class="intro-x login__input form-control py-3 px-4 block "
                placeholder="Masukkan Kurikulum" value="{{ $pengampu->kurikulum }}" name="kurikulum" id="kurikulum">
        </div>


        <div class="mt-4">
            <button class="btn btn-primary  w-full  h-10 xl:w-32 xl:mr-3 align-top" type="submit">Save </button>
            <a href="{{ route('pengampu.all') }}" class="btn btn-danger w-full h-10 xl:w-32 xl:mr-3 align-top"
                type="submit">Cancel</a>
        </div>

    </form>


    <script type="text/javascript">
        jQuery(document).ready(function() {
            $('#myForm').validate({
                rules: {
                    id_guru: {
                        required: true,
                    },
                    id_mapel: {
                        required: true,
                    },
                    kelas: {
                        required: true,
                    },
                    kurikulum: {
                        required: true,
                    },

                },
                messages: {
                    id_guru: {
                        required: 'Please Enter Your Guru',
                    },
                    id_mapel: {
                        required: 'Please Enter Your Mapel',
                    },
                    kelas: {
                        required: 'Please Enter Your Kelas',
                    },
                    kurikulum: {
                        required: 'Please Enter Your Kurikulum',
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
