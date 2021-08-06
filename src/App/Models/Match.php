<?php

namespace Asseco\PlanRouter\App\Models;

use Asseco\PlanRouter\App\Contracts\Plan;
use Asseco\PlanRouter\Database\Factories\MatchFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Match extends Model implements \Asseco\PlanRouter\App\Contracts\Match
{
    use HasFactory;

    protected $fillable = ['name'];

    protected static function newFactory()
    {
        return MatchFactory::new();
    }

    public function plans(): BelongsToMany
    {
        return $this->belongsToMany(app(Plan::class));
    }
}
