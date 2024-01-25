<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\LeaveEntitlement;

class LeavePolicies extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'days',
        'monthly',
        'advance_salary',
        'roles',
        'gender',
        'marital_status',
        'activate',
        'apply_existing_users',
    ];

    // Relationships
    public function leaveEntitlements()
    {
        return $this->hasMany(LeaveEntitlement::class);
    }
}
