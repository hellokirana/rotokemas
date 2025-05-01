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
        Schema::create('news', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->text('content')->nullable(); // artikel
            $table->string('slug')->unique()->nullable();
            $table->string('link')->nullable();  // link berita eksternal
            $table->string('link_thumbnail')->nullable(); // thumbnail link
            $table->string('featured')->default(2)->nullable();
            $table->string('image_path')->nullable(); // gambar yang diupload
            $table->string('document_path')->nullable(); // dokumen yang diupload
            $table->enum('audience', ['all', 'founder', 'member', 'partner'])->default('all'); // target pembaca
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
