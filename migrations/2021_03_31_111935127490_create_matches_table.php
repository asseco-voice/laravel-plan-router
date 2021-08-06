<?php

use Asseco\PlanRouter\App\MigrationMethodPicker;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            if (config('asseco-plan-router.uuid')) {
                $table->uuid('id')->primary();
            } else {
                $table->id();
            }

            $table->string('name')->unique();

            MigrationMethodPicker::pick($table);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matches');
    }
}
