<?php

namespace Asseco\PlanRouter\App\Models;

use Asseco\PlanRouter\Database\Factories\SkillGroupFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SkillGroup extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'email', 'sender_name', 'reply_to', 'priority'];

    protected static function newFactory()
    {
        return SkillGroupFactory::new();
    }

    public function plans(): HasMany
    {
        return $this->hasMany(Plan::class);
    }

    public function planTemplates(): HasMany
    {
        return $this->hasMany(PlanTemplate::class);
    }
}
