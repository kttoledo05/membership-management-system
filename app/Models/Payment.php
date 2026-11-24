<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['membership_transaction_id', 'payment_reference', 'amount_paid', 'payment_method', 'payment_date', 'remarks'];
    protected $casts = ['amount_paid' => 'decimal:2', 'payment_date' => 'date'];

    public function transaction() { return $this->belongsTo(MembershipTransaction::class, 'membership_transaction_id'); }
}
