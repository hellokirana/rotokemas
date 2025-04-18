<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('medias', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('kategori_id')->nullable();
            $table->string('image')->nullable();
            $table->string('title')->nullable();
            $table->string('slug')->unique()->nullable(); // slug untuk URL
            $table->text('konten')->nullable();
            $table->string('featured')->default(2)->nullable();
            $table->string('status')->nullable();
            $table->string('penulis')->nullable(); // nama penulis
            $table->string('caption')->nullable(); // caption kecil di bawah gambar
            $table->timestamp('published_at')->nullable(); // waktu tayang
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layanans');
    }
};
