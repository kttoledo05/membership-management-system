<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'membership_number', 'membership_category_id', 'membership_level_id',
        'first_name', 'last_name', 'email', 'phone', 'address', 'birthdate',
        'status', 'membership_start', 'membership_expiry',
    ];

    protected $casts = ['birthdate' => 'date', 'membership_start' => 'date', 'membership_expiry' => 'date'];

    public function category() { return $this->belongsTo(MembershipCategory::class, 'membership_category_id'); }
    public function level() { return $this->belongsTo(MembershipLevel::class, 'membership_level_id'); }
    public function transactions() { return $this->hasMany(MembershipTransaction::class); }
    public function getFullNameAttribute() { return trim($this->first_name . ' ' . $this->last_name); }
}
