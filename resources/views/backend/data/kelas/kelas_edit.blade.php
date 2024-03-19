@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script> <!-- Include jQuery Validation plugin -->
    <div class="intro-y flex items-center mt-8 mb-4">
        <h1 class="text-lg font-medium mr-auto">
            Edit Data Kelas
        </h1>
    </div>

    <form method="post" action="{{ route('kelas.update') }}" enctype="multipart/form-data" id="myForm">
        @csrf

        <input type="hidden" name="id" value="{{ $kelas->id }}">

        <div class="mt-4">
            <label for="">Tingkat</label>
            <div class="mt-1 flex">
                <div
                    class="z-30 rounded-l w-10 flex items-center justify-center
             bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800
              dark:text-slate-400 -mr-1">
                    <i data-lucide="file"></i>
                </div>
                <select name="tingkat" id="tingkat" class="tom-select w-full " required>
                    <option value="{{ $kelas->tingkat }}">{{ $kelas->tingkat }}</option>
                    <option value="X">X</option>
                    <option value="XI">XI</option>
                    <option value="XII">XII</option>
                </select>
            </div>
            <span id="error-kelas" class="text-sm text-red-600"></span>
        </div>


        <div class="mt-4">
            <label for="">Nama</label>
            <div class="mt-1 flex">
                <div
                    class="z-30 rounded-l w-10 flex items-center justify-center
             bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800
              dark:text-slate-400 -mr-1">
                    <i data-lucide="file"></i>
                </div>
                <select name="nama" id="nama" class="tom-select w-full " required>
                    <option value="{{ $kelas->nama }}">{{ $kelas->nama }}</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                    <option value="E">E</option>
                    <option value="F">F</option>
                    <option value="G">G</option>
                    <option value="H">H</option>
                    <option value="I">I</option>
                    <option value="J">J</option>

                </select>
            </div>
            <span id="error-kelas" class="text-sm text-red-600"></span>
        </div>



        <div class="mt-4">
            <label for="">Jurusan</label>
            <div class="mt-1 flex">
                <div
                    class="z-30 rounded-l w-10 flex items-center justify-center
             bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800
              dark:text-slate-400 -mr-1">
                    <i data-lucide="file"></i>
                </div>
                <select name="id_jurusan" id="id_jurusan" class="tom-select w-full " required>
                    <option value="{{ $kelas->id_jurusan }}"> {{ $kelas['jurusans']['nama'] }}</option>
                    @foreach ($jurusan as $item)
                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                    @endforeach
                </select>
            </div>
            <span id="error-kelas" class="text-sm text-red-600"></span>
        </div>
        <div class="mt-4">
              <a href="{{ route('kelas.all') }}" class="btn btn-danger h-10 w-full xl:w-32 xl:mr-2 align-top">Cancel</a>
            <button class="btn btn-primary  h-10 w-full xl:w-32 xl:mr-3 align-top" type="submit">Save</button>
          
        </div>

    </form>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            $('#myForm').validate({
                ignore: [],
                rules: {
                    nama: {
                        required: true,
                    },
                    id_jurusan: {
                        required: true,
                    },
                    tingkat: {
                        required: true,
                    },
                },
                messages: {
                    nama: {
                        required: 'Please Enter Your Nama',
                    },
                    id_jurusan: {
                        required: 'Please Enter Your Jurusan',
                    },
                    tingkat: {
                        required: 'Please Enter Your Tingkat',
                    },

                },
                errorElement: 'span',
                errorClass: 'invalid-feedback',
                errorPlacement: function(error, element) {
                    error.addClass('block text-sm text-red-600');
                    error.appendTo(element.parent().next());
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
