<?php
namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use App\Models\Mahasiswa_Matakuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Kelas;

class MahasiswaController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
       //yang semula Mahasiswa::all, diubah menjadi with() yang menyatakan relasi
        $mahasiswa = Mahasiswa::with('kelas')->get();
        $paginate = Mahasiswa::orderBy('id_mahasiswa', 'asc')->paginate(3);
        return view('mahasiswa.index', ['mahasiswa' => $mahasiswa,'paginate'=>$paginate]);
    }

    public function create(){
        $kelas = Kelas::all(); //mendapatkan data dari tabel kelas
        return view('mahasiswa.create', ['kelas' => $kelas]);
    }

    public function store(Request $request){
        //melakukan validasi data
        $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'Email' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required', 
            'Alamat' => 'required',
            'TanggalLahir' => 'required', 
        ]);
        $mahasiswa = new Mahasiswa;
        $mahasiswa->nim = $request->get('Nim');
        $mahasiswa->nama = $request->get('Nama');
        $mahasiswa->email = $request->get('Email');
        $mahasiswa->kelas_id = $request->get('Kelas');
        $mahasiswa->jurusan = $request->get('Jurusan');
        $mahasiswa->alamat = $request->get('Alamat');
        $mahasiswa->tanggallahir = $request->get('TanggalLahir');
        $mahasiswa->save();

        $kelas = new Kelas;
        $kelas->id = $request->get('Kelas');
        //fungsi eloquent untuk menambah data dengan relasi belongsTo
        $mahasiswa->kelas()->associate($kelas);
        $mahasiswa->save();
        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('mahasiswa.index')
        ->with('success', 'Mahasiswa Berhasil Ditambahkan');
    }

    public function show($Nim){
        //menampilkan detail data dengan menemukan/berdasarkan Nim Mahasiswa
        //$Mahasiswa = Mahasiswa::find($Nim);
       
            //menampilkan detail data dengan menemukan/berdasarkan Nim Mahasiswa
            $mahasiswa = Mahasiswa::with('kelas')->where('nim', $Nim)->first();
                return view('mahasiswa.detail', ['Mahasiswa' => $mahasiswa]);
        
        
    }
    public function edit($Nim)
    {
        //menampilkan detail data dengan menemukan berdasarkan Nim Mahasiswa untuk diedit
        $Mahasiswa = Mahasiswa::with('Kelas')->where('nim', $Nim)->first();
        $kelas = Kelas::all();//mendapatkan data dari tabel kelas
        return view('mahasiswa.edit', compact('Mahasiswa','kelas'));
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $Nim)
    {
        //melakukan validasi data
        $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required',
            'Email' => 'required',
            'Alamat' => 'required',
            'TanggalLahir' => 'required',
        ]);
        $mahasiswa = Mahasiswa::with('Kelas')->where('Nim', $Nim)->first();
        $mahasiswa->nim = $request->get('Nim');
        $mahasiswa->nama = $request->get('Nama');
        $mahasiswa->email = $request->get('Email');
        $mahasiswa->jurusan = $request->get('Jurusan');
        $mahasiswa->alamat = $request->get('Alamat');
        $mahasiswa->tanggallahir = $request->get('TanggalLahir');

        $kelas = new Kelas;
        $kelas->id = $request->get('Kelas');

        // fungsi eloquent untuk mengupdate data dengan relasi belongsTo
        // Mahasiswa::where('nim', $Nim)->first()->update($request->all());
        $mahasiswa->kelas()->associate($kelas);
        $mahasiswa->save();
        
        //jika data berhasil diupdate, akan kembali ke halaman utama
        return redirect()->route('mahasiswa.index')
        ->with('success', 'Mahasiswa Berhasil Diupdate');
    }
    public function destroy( $Nim){
        //fungsi eloquent untuk menghapus data
        Mahasiswa::find($Nim)->delete();
        return redirect()->route('mahasiswa.index')
        -> with('success', 'Mahasiswa Berhasil Dihapus');
    }
    public function search(Request $request){
		$search = $request->search;
		$mahasiswa = DB::table('mahasiswa')
		->where('nim','like',"%".$search."%")
        ->orWhere('nama','like', "%".$search."%") 
        ->orWhere('kelas','like', "%".$search."%")
        ->orWhere('jurusan','like', "%".$search."%")
        ->orWhere('email','like', "%".$search."%")
        ->orWhere('alamat','like', "%".$search."%")
        ->orWhere('tanggallahir','like', "%".$search."%")->paginate(3);
        return view('mahasiswa.index', compact('mahasiswa'))->with('i', (request()->input('page', 1) - 1) * 5);	
    }

    public function nilai($id){
        $Mahasiswa = Mahasiswa::with('kelas')
            ->where('id_mahasiswa' , $id)->first();
        $matkul = Mahasiswa_Matakuliah::with('matakuliah')
            ->where('mahasiswa_id', $id)->get();
        return view('mahasiswa.nilai', compact('Mahasiswa', 'matkul'));
    }
};  