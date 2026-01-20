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
        Schema::table('configuracoes', function (Blueprint $table) {
            $table->string('whatsapp_api_url')->nullable()->after('email');
            $table->string('whatsapp_api_token')->nullable()->after('whatsapp_api_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('configuracoes', function (Blueprint $table) {
            $table->dropColumn(['whatsapp_api_url', 'whatsapp_api_token']);
        });
    }
};
