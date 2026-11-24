<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembershipLevel extends Model
{
    protected $fillable = ['name', 'fee', 'validity_months', 'benefits', 'is_active'];

    protected $casts = ['fee' => 'decimal:2', 'is_active' => 'boolean'];

    public function members() { return $this->hasMany(Member::class); }
}
