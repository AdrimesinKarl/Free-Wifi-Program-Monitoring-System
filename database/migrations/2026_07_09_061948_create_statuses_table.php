<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('color')->default('#6b7280');
            $table->timestamps();
        });

        DB::table('statuses')->insert([
            [
                'name' => 'Active',
                'color' => '#22C55E',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'For Renewal',
                'color' => '#F59E0B',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Terminated',
                'color' => '#EF4444',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statuses');
    }
};