@extends('admin.admin_master')
@section('admin')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script> <!-- Include jQuery Validation plugin -->
    <div class="intro-y flex items-center mt-8 mb-4">
        <h1 class="text-lg font-medium mr-auto">
            Add Data Waktu
        </h1>
    </div>

    <form method="post" action="{{ route('waktu.store') }}" enctype="multipart/form-data" id="myForm">
        @csrf

        <div class="mt-4">
            <label for="">Kode Waktu</label>
            <div class="input-group mt-1">
                <div id="input-group-email" class="input-group-text">
                    <i data-lucide="code-2"></i>
                </div>
                <input class="intro-x login__input form-control py-3 px-4 block" type="text"
                    placeholder="Masukkan Kode Waktu" name="kode_waktu" id="kode_waktu" required>
            </div>
            <span id="error-kurikulum" class="text-sm text-red-600"></span>
        </div>

        <div class="mt-4">
            <label for="">Waktu Mulai</label>
            <div class="input-group mt-1">
                <div id="input-group-email" class="input-group-text">
                    <i data-lucide="clock"></i>
                </div>
                <input type="time" class="intro-x login__input form-control py-3 px-4 block" placeholder="Waktu Mulai"
                    name="waktu_mulai" id="waktu_mulai" required>
            </div>
            <span id="error-kurikulum" class="text-sm text-red-600"></span>
        </div>

        <div class="mt-4">
            <label for="">Waktu Akhir</label>
            <div class="input-group mt-1">
                <div id="input-group-email" class="input-group-text">
                    <i data-lucide="clock"></i>
                </div>
                <input type="time" class="intro-x login__input form-control py-3 px-4 block" placeholder="Waktu Akhir"
                    name="waktu_akhir" id="waktu_akhir" required>
            </div>
            <span id="error-kurikulum" class="text-sm text-red-600"></span>
        </div>


        <div class="mt-4">
            <label for="">Jam Pelajaran</label>

            <div class="mt-1 flex">
                <div
                    class="z-30 rounded-l w-10 flex items-center justify-center
             bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800
              dark:text-slate-400 -mr-1">
                    <i data-lucide="clock"></i>
                </div>
                <select name="jp" id="jp" class="tom-select w-full " required>
                    <option value="">Pilih Jp</option>
                    <option value="1">1 Jp</option>
                    <option value="2">2 Jp</option>
                    <option value="3">3 Jp</option>
                    <option value="4">4 Jp</option>
                    <option value="5">5 JP</option>
                    <option value="6">6 JP</option>

                </select>
            </div>
            <span id="error-kelas" class="text-sm text-red-600"></span>
        </div>
        <div class="mt-4">
            <button class="btn btn-primary  py-3 px-4 w-full xl:w-32 xl:mr-3 align-top" type="submit">Save </button>
            <a href="{{ route('waktu.all') }}" class="btn btn-danger  py-3 px-4 w-full xl:w-32 xl:mr-3 align-top"
                type="submit">Cancel</a>
        </div>

    </form>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            $('#myForm').validate({
                ignore: [],
                rules: {
                    kode_waktu: {
                        required: true,
                    },
                    waktu_mulai: {
                        required: true,
                    },
                    waktu_akhir: {
                        required: true,
                    },
                    range: {
                        required: true,
                    },
                    jp: {
                        required: true,
                    },
                },
                messages: {
                    kode_waktu: {
                        required: 'Please Enter Your Kode Waktu',
                    },
                    waktu_mulai: {
                        required: 'Please Enter Your Waktu Mulai',
                    },
                    waktu_akhir: {
                        required: 'Please Enter Your Waktu Akhir,',
                    },
                    range: {
                        required: 'Please Enter Your Range',
                    },
                    jp: {
                        required: 'Please Enter Your Jp',
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
