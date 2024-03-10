<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\LeaveEntitlement;
use App\Models\Role;

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
        "max_days",
        "is_unlimited"
    ];

    // Relationships
    public function leaveEntitlements()
    {
        return $this->hasMany(LeaveEntitlement::class);
    }

    public function Roles()
    {
        return $this->hasMany(Role::class);
    }
  }
