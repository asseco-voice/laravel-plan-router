<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameMatchPlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('match_plan', function (Blueprint $table) {
            $table->renameIndex('match_plan_plan_id_match_id_unique', 'plan_rule_plan_id_rule_id_unique');
        });

        Schema::table('match_plan', function (Blueprint $table) {
            $table->renameColumn('match_id', 'rule_id');
        });

        Schema::rename('match_plan', 'plan_rule');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('plan_rule', 'match_plan');

        Schema::table('match_plan', function (Blueprint $table) {
            $table->renameColumn('rule_id', 'match_id');
        });

        Schema::table('match_plan', function (Blueprint $table) {
            $table->renameIndex('plan_rule_plan_id_rule_id_unique', 'match_plan_plan_id_match_id_unique');
        });
    }
}
