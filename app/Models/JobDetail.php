<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'hired_at',
        'joined_at',
        'start_year',
        'end_year',
        'resigned_at',
        'source_of_hire',
        'job_type',
        'status',
        'salary',
        'iban',
        'bank_name',
        'bank_account_number',
        'payment_method',
        'recived_email_notification',
        'user_id',
        'supervisor_id',
    ];

    // Define relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }
}
