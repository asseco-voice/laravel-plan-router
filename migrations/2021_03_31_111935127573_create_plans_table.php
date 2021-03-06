<?php

use Asseco\BlueprintAudit\App\MigrationMethodPicker;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            if (config('asseco-plan-router.migrations.uuid')) {
                $table->uuid('id')->primary();
            } else {
                $table->id();
            }

            $table->string('name');
            $table->string('description')->nullable();
            $table->integer('priority')->default(false);
            $table->boolean('match_either')->default(false);

            MigrationMethodPicker::pick($table, config('asseco-plan-router.migrations.timestamps'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans');
    }
}
