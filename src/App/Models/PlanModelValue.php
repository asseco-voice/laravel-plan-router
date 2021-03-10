<?php

namespace Asseco\PlanRouter\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlanModelValue extends Model
{
    use HasFactory;

    protected $fillable = ['plan_id', 'field_id', 'value'];

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }
}
