<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LateAttendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'from',
        'to',
        'reason',
        'approved',
        'reject_reason',
        'approved_by',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
