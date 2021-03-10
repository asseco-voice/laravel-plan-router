<?php

namespace Asseco\PlanRouter\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Match extends Model
{
    protected $fillable = ['name'];

    public function plans(): BelongsToMany
    {
        return $this->belongsToMany(Plan::class);
    }
}
