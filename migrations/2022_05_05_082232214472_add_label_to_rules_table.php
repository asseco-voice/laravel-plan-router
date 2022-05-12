<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddLabelToRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rules', function (Blueprint $table) {
            $table->string('label')->nullable()->after('name');
        });

        $this->consolidate();

        Schema::table('rules', function (Blueprint $table) {
            $table->string('label')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rules', function (Blueprint $table) {
            $table->dropColumn('label');
        });
    }

    protected function consolidate(): void
    {
        $rules = DB::table('rules')->get();

        foreach ($rules as $rule) {
            DB::table('rules')->where('id', $rule->id)->update([
                'label' => $rule->name,
            ]);
        }
    }
}
