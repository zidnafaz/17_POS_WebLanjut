<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('m_user', function (Blueprint $table) {
            $table->string('profile_picture')->nullable()->after('password');
        });
    }

    public function down(): void
    {
        Schema::table('m_user', function (Blueprint $table) {
            $table->dropColumn('profile_picture');
        });
    }
};
