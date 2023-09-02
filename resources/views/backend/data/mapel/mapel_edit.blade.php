@extends('admin.admin_master')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <div class="intro-y flex items-center mt-8 mb-4">
        <h1 class="text-lg font-medium mr-auto">
            Add Mapel
        </h1>
    </div>

    <form method="post" action="{{ route('mapel.update') }}" enctype="multipart/form-data" id="myForm">
        @csrf
        
        <input type="hidden" name="id" value="{{ $mapel->id }}">
        <div  class="mt-3"> <label for="regular-form-1" class="form-label">Mata Pelajaran</label> 
        <input type="text" value="{{ $mapel->nama }}" class="intro-x login__input form-control py-3 px-4 block " placeholder="Nama Mapel" name="nama"
            id="nama"> </div>
               <div  class="mt-3"> <label for="regular-form-1" class="form-label">Jenis</label> 
        <select name="jenis" id="jenis" data-placeholder="Select Jenis" class="tom-select w-full   ">
            <option value="{{$mapel->jenis}}">
                @if ($mapel->jenis == "1")
                    UMUM
                @elseif ($mapel->jenis == "2")
                    PROD
                @elseif ($mapel->jenis == "2")
                    Belum di Pilih
                @endif
            </option>
            <option value="1">Umum</option>
            <option value="2">Jurusan</option>
        </select>
               </div>
                      <div class="mt-3"> <label for="regular-form-1" class="form-label">Jam Pelajaran</label> 
         <select name="jp" id="jp" data-placeholder="Select Jam Pelajaran" class="tom-select w-full   ">
            <option value="{{$mapel->jp}}">
                 {{$mapel->jp}} JP
            </option>
                <option value="1">1 JP</option>
                <option value="2">2 JP</option>
                <option value="3">3 JP</option>
                <option value="4">4 JP</option>
                <option value="5">5 JP</option>
                <option value="6">6 JP</option>
                <option value="7">7 JP</option>
                <option value="8">8 JP</option>
                <option value="9">9 JP</option>
                <option value="10">10 JP</option>
                 <option value="11">11 JP</option>
        </select>
                      </div>
               <div  class="mt-3"> <label for="regular-form-1" class="form-label">Ruangan</label> 
        <input type="text" value="{{ $mapel->kode_ruangan }}" class="intro-x login__input form-control py-3 px-4 block " placeholder="Ruangan" name="kode_ruangan"
            id="kode_ruangan">
               </div>





        <button class="btn btn-primary mt-3 py-3 px-4 w-full xl:w-32 xl:mr-3 align-top" type="submit">Update</button>
    </form>

      <script type="text/javascript">
        jQuery(document).ready(function() {
            $('#myForm').validate({
                rules: {
                  
                    nama: {
                        required: true,
                    },
                    jenis: {
                        required: true,
                    },
                    jp: {
                        required: true,
                    },
                     kode_ruangan: {
                        required: true,
                    },

                },
                messages: {
                   
                    nama: {
                        required: 'Please Enter Your Nama',
                    },
                    jenis: {
                        required: 'Please Enter Your Jenis',
                    },
                    jp: {
                        required: 'Please Enter Your Jam Pelajaran',
                    },
                     kode_ruangan: {
                        required: 'Please Enter Your Ruangan',
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
@endsection
