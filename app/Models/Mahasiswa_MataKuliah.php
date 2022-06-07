<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Mahasiswa;
use App\Models\matakuliah;

class Mahasiswa_MataKuliah extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'mahasiswa_matakuliah';

    protected $fillable = [
        'mahasiswa_id',
        'matakuliah_id',
        'nilai',
    ];
    
    public function mahasiswa(){
        return $this->belongsTo(Mahasiswa::class);
    }public function matakuliah(){
        return $this->belongsTo(Matakuliah::class);
    }
}