<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class longLeave extends Model
{
    use HasFactory;
    protected $fillable = [
        'from',
        'to',
        'reason',
        'approved',
        'user_id',
        'policy_id',
        'approved_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
    public function policy()
    {
        return $this->belongsTo(LeavePolicies::class, 'policy_id');
    }

}

