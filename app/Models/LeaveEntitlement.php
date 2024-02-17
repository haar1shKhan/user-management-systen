<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\LeavePolicies;
use App\Models\User;


class LeaveEntitlement extends Model
{
    use HasFactory;

    protected $fillable = [
        'leave_policy_id',
        'leave_year',
        'days',
        'user_id',
        'leave_taken',
    ];

    // Relationships
    public function policy()
    {
        return $this->belongsTo(LeavePolicies::class, 'leave_policy_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
