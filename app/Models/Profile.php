<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'passport',
        'email',
        'nid',
        'phone',
        'mobile',
        'date_of_birth',
        'gender',
        'nationality',
        'marital_status',
        'biography',
        'address',
        'address2',
        'city',
        'province',
        'country',
        'religion',
        'passport_issued_at',
        'passport_expires_at',
        'passport_file',
        'nid_issued_at',
        'nid_expires_at',
        'nid_file',
        'visa',
        'visa_issued_at',
        'visa_expires_at',
        'visa_file',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
