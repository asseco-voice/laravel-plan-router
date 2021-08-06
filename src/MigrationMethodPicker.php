<?php

namespace Asseco\PlanRouter\App;

use Illuminate\Database\Schema\Blueprint;

class MigrationMethodPicker
{
    public static function pick(Blueprint $table)
    {
        switch (config('asseco-plan-router.audit')) {
            case 'soft':
                $table->timestamps();
                $table->softDeletes();
                break;
            case 'partial':
                $table->audit();
                break;
            case 'full':
                $table->softDeleteAudit();
                break;
            default:
                $table->timestamps();
                break;
        }
    }
}
