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
        Schema::create('locations', function (Blueprint $table) {
        $table->id();
        $table->string('site_name');
        $table->string('barangay');
        $table->foreignId('municipality_id')->constrained()->cascadeOnDelete();
        $table->foreignId('status_id')->constrained();
        $table->decimal('latitude', 10, 7)->nullable();
        $table->decimal('longitude', 10, 7)->nullable();
       // $table->date('start_date')->nullable();
       // $table->date('renewal_date')->nullable();
        $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
