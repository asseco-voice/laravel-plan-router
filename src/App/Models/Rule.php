<?php

namespace Asseco\PlanRouter\App\Models;

use Asseco\PlanRouter\App\Contracts\Plan;
use Asseco\PlanRouter\Database\Factories\RuleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Rule extends Model implements \Asseco\PlanRouter\App\Contracts\Rule
{
    use HasFactory;

    protected $fillable = ['name', 'label'];

    protected static function newFactory()
    {
        return RuleFactory::new();
    }

    public function plans(): BelongsToMany
    {
        return $this->belongsToMany(app(Plan::class));
    }

    public static function getValidationRules(): array
    {
        return [
            'name' => 'required|string',
            'label' => 'required|string',
        ];
    }
}
