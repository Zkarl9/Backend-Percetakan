<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ecommerce', function (Blueprint $table) {
            $table->string('image')->nullable()->after('url_link');
        });
    }

    public function down(): void
    {
        Schema::table('ecommerce', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
};