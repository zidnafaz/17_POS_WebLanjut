<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('m_suplier', function (Blueprint $table) {
            $table->bigIncrements('id_suplier');
            $table->string('kode_suplier', 10);
            $table->string('nama_suplier', 100);
            $table->string('no_telepon', 15)->nullable();
            $table->text('alamat')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('m_suplier');
    }
};
