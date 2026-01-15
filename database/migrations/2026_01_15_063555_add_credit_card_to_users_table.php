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
        Schema::table('users', function (Blueprint $table) {
            // !!! VULNERABILITY: CRYPTOGRAPHIC FAILURE !!!
            // Menyimpan data kartu kredit sebagai plaintext sangat berbahaya.
            $table->text('card_number');
            $table->text('card_expiry');
            $table->text('card_cvv');
            $table->text('card_holder_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
