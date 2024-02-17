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
        'entitlement_id',
        'leave_file',
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
    public function entitlement()
    {
        return $this->belongsTo(LeaveEntitlement::class, 'entitlement_id');
    }

}

