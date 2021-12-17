<?php

use Asseco\BlueprintAudit\App\MigrationMethodPicker;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

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
            if (config('asseco-plan-router.migrations.uuid')) {
                $table->uuid('id')->primary();
            } else {
                $table->id();
            }

            $table->string('name')->unique();

            MigrationMethodPicker::pick($table, config('asseco-plan-router.migrations.timestamps'));
        });

        $this->seedData();
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

    protected function seedData(): void
    {
        $data = [
            [
                'name'       => 'from',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'to',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'cc',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'bcc',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'subject',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        if (config('asseco-plan-router.migrations.uuid')) {
            foreach ($data as &$item) {
                $item = array_merge($item, [
                    'id' => Str::uuid(),
                ]);
            }
        }

        DB::table('matches')->insert($data);
    }
}
