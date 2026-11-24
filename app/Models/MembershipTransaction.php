<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembershipTransaction extends Model
{
    protected $fillable = ['member_id', 'reference_number', 'type', 'status', 'amount', 'transaction_date', 'remarks'];
    protected $casts = ['amount' => 'decimal:2', 'transaction_date' => 'date'];

    public function member() { return $this->belongsTo(Member::class); }
    public function payments() { return $this->hasMany(Payment::class); }
}
