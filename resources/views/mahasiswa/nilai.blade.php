@extends('mahasiswa.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left mt-2">
                <h2 align="center">JURUSAN TEKNOLOGI INFORMASI-POLITEKNIK NEGERI MALANG</h2>
                <br>
                <h1 align="center">KARTU HASIL STUDI (KHS)</h1>
            </div>
            <br><br>
            
           
            <div class="float-left my-2">
                <p><strong>Nama :</strong> {{$Mahasiswa->nama}}</p>
                <p><strong>NIM :</strong> {{$Mahasiswa->nim}}</p>
                <p><strong>Kelas :</strong> {{$Mahasiswa->kelas->nama_kelas }}</p>
            </div>
        </div>
    </div>

    <table class="table table-bordered mt-3">
        <tr>
            <th><strong>Mata Kuliah</strong></th>
            <th><strong>SKS</strong></th>
            <th><strong>Semester</strong></th>
            <th><strong>Nilai</strong></th>
        </tr>
        @foreach($matkul as $score)
        <tr>
            <td>{{$score->matakuliah->nama_matkul}}</td>
            <td>{{$score->matakuliah->sks}}</td>
            <td>{{$score->matakuliah->semester}}</td>
            <td>{{$score->nilai}}</td>
        </tr>
        @endforeach

    </table>
    <div class="float-right my-2">
        <a class="btn btn-success mt-3" href="{{ route('mahasiswa.index') }}">Kembali</a>
    </div>
    @endsection