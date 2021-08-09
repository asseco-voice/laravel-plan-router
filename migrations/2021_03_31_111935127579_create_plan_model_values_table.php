<?php

use Asseco\Common\App\MigrationMethodPicker;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanModelValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_model_values', function (Blueprint $table) {
            if (config('asseco-plan-router.uuid')) {
                $table->uuid('id')->primary();
                $table->foreignUuid('plan_id')->constrained()->cascadeOnDelete();
            } else {
                $table->id();
                $table->foreignId('plan_id')->constrained()->cascadeOnDelete();
            }

            $table->string('attribute');
            $table->string('value');

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
        Schema::dropIfExists('plan_model_values');
    }
}
