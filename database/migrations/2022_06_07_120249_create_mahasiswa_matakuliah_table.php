<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMahasiswaMatakuliahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('mahasiswa_matakuliah', function (Blueprint $table) {
        //         $table->id();
        //         $table->unsignedBigInteger('mahasiswa_id')->nullable();
        //         $table->foreign('mahasiswa_id')->references('id_mahasiswa')->on('mahasiswa');
        //         $table->unsignedBigInteger('matakuliah_id')->nullable();
        //         $table->foreign('matakuliah_id')->references('id')->on('matakuliah');
        //         $table->integer('nilai');
        //         $table->timestamps();
            
        // });
        Schema::create('mahasiswa_matakuliah', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->references('id_mahasiswa')->on('mahasiswa');//menambahkan foreign key di kolom mahasiswa_id
            $table->foreignId('matakuliah_id')->references('id')->on('matakuliah');//menambahkan foreign key di kolom matakuliah_id
            $table->char('nilai',1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mahasiswa_matakuliah');
    }

}