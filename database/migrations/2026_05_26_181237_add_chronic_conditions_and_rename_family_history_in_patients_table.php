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
        Schema::table('patients', function (Blueprint $table) {
            $table->renameColumn('family_medical_history', 'family_history');
            $table->string('chronic_conditions')->nullable()->after('surgical_history');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->renameColumn('family_history', 'family_medical_history');
            $table->dropColumn('chronic_conditions');
        });
    }
};
