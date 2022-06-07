<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Matakuliah;

class MataKuliah extends Model
{
    protected $table='matakuliah'; 
    protected $primaryKey = 'id';

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'NamaMatkul',
            'SKS',
            'Jam',
            'Semester',
        ];
    
        public function mahasiswa_matakuliah()
    {
        return $this->hasMany(Mahasiswa_Matakuliah::class);
        //return $this->belongsToMany(Mahasiswa::class, 'mahasiswa_matakuliah');
    }
}