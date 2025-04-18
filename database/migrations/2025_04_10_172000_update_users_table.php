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
        Schema::table('users', function (Blueprint $table) {
             // Rename field bawaan
            $table->renameColumn('name', 'company_name');
            $table->renameColumn('email', 'company_email');

            // Data Perusahaan
            $table->string('founded_year')->nullable();
            $table->text('company_address')->nullable();
            $table->string('company_phone')->nullable();
            $table->string('company_website')->nullable();

            // Contact Person
            $table->string('contact_name')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_department')->nullable();
            $table->string('contact_position')->nullable();
            $table->string('contact_email')->nullable();

            // Kriteria Perusahaan
            $table->string('business_type')->nullable();
            $table->string('total_employee')->nullable();
            $table->string('printing_line_total')->nullable();
            $table->string('process_printing')->nullable();
            $table->string('process')->nullable();
            $table->string('anual_turnover')->nullable();
            $table->string('film_production')->nullable();

            // Status verifikasi member
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamp('verified_at')->nullable();

            // Jenis member
            $table->enum('type', ['founder', 'member', 'partner'])->default('member');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('company_name', 'name');
            $table->renameColumn('company_email', 'email');

            $table->dropColumn([
                'founded_year',
                'company_address',
                'company_phone',
                'company_website',
                'contact_name',
                'contact_phone',
                'contact_department',
                'contact_position',
                'contact_email',
                'business_type',
                'total_employee',
                'printing_line_total',
                'process_printing',
                'process',
                'anual_turnover',
                'film_production',
                'status',
                'verified_at',
                'type',
            ]);
        });
    }
};
