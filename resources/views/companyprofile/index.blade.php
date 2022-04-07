@extends('layout.index')

@section('title')
    Company Profile
@endsection

@section('judul')
    Company Profile
@endsection

@section('content')
    <form action="" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nama">Nama Perusahaan</label>
                    <input type="text" name="nama" class="form-control form-control-sm" value="{{ old('nama',isset($data['nama']) ? $data['nama'] : '') }}">
                    <div class="text-danger">
                        @error('nama')
                            <small>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea name="alamat" class="form-control form-control-sm" rows="5">{{ old('alamat',isset($data['alamat']) ? $data['alamat'] : '') }}</textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" class="form-control form-control-sm" value="{{ old('email',isset($data['email']) ? $data['email'] : '') }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="telepon">Phone</label>
                    <input type="text" name="telepon" class="form-control form-control-sm" value="{{ old('telepon',isset($data['telepon']) ? $data['telepon'] : '') }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="website">Website</label>
                    <input type="text" name="website" class="form-control form-control-sm" value="{{ old('website',isset($data['website']) ? $data['website'] : '') }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="pemilik">Pemilik</label>
                    <input type="text" name="pemilik" class="form-control form-control-sm" value="{{ old('pemilik',isset($data['pemilik']) ? $data['pemilik'] : '') }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="tanggal_berdiri">Tanggal berdiri</label>
                    <div class="input-group date" data-date-format="dd-mm-yyyy" data-provide="datepicker">
                        <input type="text" class="form-control input-sm" name="tanggal_berdiri" id="from" value="{{ old('tanggal_berdiri',isset($data['tanggal_berdiri']) && $data['tanggal_berdiri'] != '' ? date('d-m-Y',strtotime($data['tanggal_berdiri'])) : '') }}" >
                        <span class="input-group-addon"><button class="btn btn-primary" type="button"><i class="fa fa-calendar"></i></button></span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="logo">Upload Logo</label>
                    <input type="file" name="logo" id="logo" class="form-control-sm form-control-sm">
                </div>
            </div>
        </div>
        <div class="row text-center">
            <div class="col">
                <button type="submit" class="btn btn-sm btn-primary">Submit</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 offset-md-4">
                @if (isset($data['logo']) && $data['logo'] != '' && file_exists("C:\\xampp\\htdocs\\project\\cafe\\public\\assets\\images\\".$data['logo']))
                    <img src="{{ url('/') }}/assets/images/{{ $data['logo'] }}" class="img-fluid img-thumbnail rounded" alt="Logo">
                @endif
            </div>
        </div>
    </form>
@endsection

@section('js')
    <script>
        $(document).ready(function(){
            $("#logo").on("change",function(){
                validateImageUpload('logo');
            });
            $('.input-group.date').datepicker({
                format: "dd-mm-yyyy",
                todayBtn: "linked",
                //startDate: "+1d",
                autoclose: true,
                todayHighlight: true,
                clearBtn: true
            });
        });
    </script>
@endsection