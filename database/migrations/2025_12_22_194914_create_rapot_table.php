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
        Schema::create('rapot', function (Blueprint $table) {
            $table->id();

            $table->foreignId('santri_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('admin_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('semester_id')
                ->constrained('semester')
                ->cascadeOnDelete();

            $table->integer('nilai_akademik')->nullable();
            $table->integer('nilai_akhlak')->nullable();
            $table->integer('kehadiran')->nullable();
            $table->text('catatan_guru')->nullable();

            $table->dateTime('tanggal_input')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rapot');
    }
};
