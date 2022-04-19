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

    protected $fillable = ['name'];

    protected static function newFactory()
    {
        return RuleFactory::new();
    }

    public function plans(): BelongsToMany
    {
        return $this->belongsToMany(app(Plan::class));
    }
}
