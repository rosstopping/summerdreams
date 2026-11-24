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
        if (! Schema::hasColumn('packages', 'currency')) {
            Schema::table('packages', function (Blueprint $table) {
                $table->string('currency')->default('GBP')->after('deposit');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // The earlier events-and-packages migration owns this column.
        // Its down method removes it when that migration is rolled back.
    }
};
