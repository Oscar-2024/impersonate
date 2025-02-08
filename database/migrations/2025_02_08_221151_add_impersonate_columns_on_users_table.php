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
            $table->boolean('can_impersonate')->default(false)->after('remember_token');
            $table->boolean('can_be_impersonated')->default(true)->after('can_impersonate');
            $table->unsignedBigInteger('impersonating_to')->nullable()->after('can_be_impersonated');
            $table->timestamp('impersonated_at')->nullable()->after('impersonating_to');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('can_impersonate');
            $table->dropColumn('can_be_impersonated');
            $table->dropColumn('impersonating_to');
            $table->dropColumn('impersonated_at');
        });
    }
};
