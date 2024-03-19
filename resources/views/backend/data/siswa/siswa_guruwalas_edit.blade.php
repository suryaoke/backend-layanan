@extends('admin.admin_master')
@section('admin')
    <form method="post" action="{{ route('siswa.walas.update') }}" enctype="multipart/form-data" id="myForm">
        @csrf

        <input type="hidden" name="id" value="{{ $siswa->id }}">

        <div class="intro-y box py-5 sm:py-5 mt-5">
            <div class="flex justify-center">
                <img src=" {{ !empty($siswa->users->profile_image) ? url('uploads/admin_images/' . $siswa->users->profile_image) : url('backend/dist/images/profile-user.png') }}"
                    style="max-width:150px; max-height:160px" alt="User Image">
            </div>

            <div class="px-5 sm:px-20 mt-5 pt-10 border-t border-slate-200/60 dark:border-darkmode-400">
                <div class="font-medium text-base">Biodata Siswa</div>
                <div class="grid grid-cols-12 gap-4 gap-y-5 mt-5">
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-1" class="form-label">Nis</label>
                        <input type="text" name="nis" value="{{ $siswa->nis }}" class="form-control">
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-2" class="form-label">Alamat Siswa</label>
                        <input type="text" class="form-control" name="alamat_siswa" value="{{ $siswa->alamat_siswa }}">
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-3" class="form-label">Nisn</label>
                        <input id="nisn" type="text" class="form-control" name="nisn"
                            value="{{ $siswa->nisn }}">
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-4" class="form-label">Alamat Sekolah</label>
                        <input type="text" class="form-control" name="alamat_sekolah"
                            value="{{ $siswa->alamat_sekolah }}">
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-5" class="form-label">Nama</label>
                        <input id="nama" type="text" class="form-control" name="nama"
                            value="{{ $siswa->nama }}">
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-6" class="form-label">Nama Ayah</label>
                        <input type="text" class="form-control" name="nama_ayah" value="{{ $siswa->nama_ayah }}">
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-6" class="form-label">Jenis Kelamin</label>
                        <select name="jk" class="form-select">
                            <option value="L">Laki - Laki</option>
                            <option value="P">Perempuan</option>

                        </select>
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-6" class="form-label">Nama Ibu</label>
                        <input type="text" class="form-control" name="nama_ibu" value="{{ $siswa->nama_ibu }}">
                    </div>

                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-6" class="form-label">Tempat Lahir</label>
                        <input type="text" value="{{ $siswa->tempat }}"
                            class="intro-x login__input form-control py-3 px-4 block mt-1" name="tempat" id="tempat">
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-6" class="form-label">Pekerjaan Ayah</label>
                        <input type="text" value="{{ $siswa->pekerjaan_ayah }}"
                            class="intro-x login__input form-control py-3 px-4 block mt-1" name="pekerjaan_ayah">
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-6" class="form-label">Tanggal Lahir</label>
                        <input type="date" value="{{ $siswa->tanggal }}"
                            class="intro-x login__input form-control py-3 px-4 block mt-1" name="tanggal" id="tanggal">
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-6" class="form-label">Pekerjaan Ibu</label>
                        <input type="text" value="{{ $siswa->pekerjaan_ibu }}"
                            class="intro-x login__input form-control py-3 px-4 block mt-1" name="pekerjaan_ibu">
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-6" class="form-label">Agama</label>
                        <input type="text" value="{{ $siswa->agama }}"
                            class="intro-x login__input form-control py-3 px-4 block mt-1" name="agama">
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-6" class="form-label">Alamat Orang Tua</label>
                        <input type="text" value="{{ $siswa->alamat_ortu }}"
                            class="intro-x login__input form-control py-3 px-4 block mt-1" name="alamat_ortu">
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-6" class="form-label">Status Keluarga</label>
                        <input type="text" value="{{ $siswa->status_keluarga }}"
                            class="intro-x login__input form-control py-3 px-4 block mt-1" name="status_keluarga">
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-6" class="form-label">Nama Wali</label>
                        <input type="text" value="{{ $siswa->nama_wali }}"
                            class="intro-x login__input form-control py-3 px-4 block mt-1" name="nama_wali">
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-6" class="form-label">Anak Ke</label>
                        <input type="text" value="{{ $siswa->anak_ke }}"
                            class="intro-x login__input form-control py-3 px-4 block mt-1" name="anak_ke"
                            pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-6" class="form-label">Pekerjaan Wali</label>
                        <input type="text" value="{{ $siswa->pekerjaan_wali }}"
                            class="intro-x login__input form-control py-3 px-4 block mt-1" name="pekerjaan_wali">
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-6" class="form-label">Telepon Siswa</label>
                        <input type="text" value="{{ $siswa->no_hp }}"
                            class="intro-x login__input form-control py-3 px-4 block mt-1" name="no_hp"
                            pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-6" class="form-label">Alamat Wali</label>
                        <input type="text" value="{{ $siswa->alamat_wali }}"
                            class="intro-x login__input form-control py-3 px-4 block mt-1" name="alamat_wali">
                    </div>

                    <div class="intro-y col-span-12 flex items-center justify-center sm:justify-end mt-5">
                        <a href="{{ route('siswa.guruwalas') }}" class="btn btn-danger w-24 ml-2 "
                            type="submit">Cancel</a>
                        <button type="submit" class="btn btn-primary w-24 ml-2">Save</button>
                    </div>
                </div>
            </div>
        </div><!-- end row -->
    </form>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#myForm').validate({
                rules: {
                    nisn: {
                        required: true,
                    },
                    nama: {
                        required: true,
                    },

                    tempat: {
                        required: true,
                    },
                    tanggal: {
                        required: true,
                    },
                },
                messages: {
                    nama: {
                        required: 'Please Enter Your Nama',
                    },
                    nisn: {
                        required: 'Please Enter Your NISN',
                    },

                    tempat: {
                        required: 'Please Select Your Tempat',
                    },
                    tanggal: {
                        required: 'Please Select Your Tanggal',
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
