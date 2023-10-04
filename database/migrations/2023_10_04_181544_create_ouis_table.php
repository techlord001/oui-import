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
        Schema::create('ouis', function (Blueprint $table) {
            $table->id();
            $table->string('registry')->nullable();
            $table->string('assignment')->nullable();
            $table->string('organization_name', 255)->nullable();
            $table->string('organization_address', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ouis');
    }
};
