<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('santri_detail', function (Blueprint $table) {
            $table->string('nama_wali')->after('no_hp');
            $table->string('no_hp_wali')->after('nama_wali');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('santri_detail', function (Blueprint $table) {
            $table->dropColumn(['nama_wali', 'no_hp_wali']);
        });
    }
};
