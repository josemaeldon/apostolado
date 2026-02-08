<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberRegistration extends Model
{
    protected $fillable = [
        'parish',
        'full_name',
        'cpf',
        'address',
        'phone',
        'email',
        'birth_date',
        'marital_status',
        'profession',
        'member_city',
        'member_parish',
        'baptism_date',
        'commitment_1',
        'commitment_2',
        'commitment_3',
        'commitment_4',
        'commitment_5',
        'how_met',
        'why_join',
        'status',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'baptism_date' => 'date',
        'commitment_1' => 'boolean',
        'commitment_2' => 'boolean',
        'commitment_3' => 'boolean',
        'commitment_4' => 'boolean',
        'commitment_5' => 'boolean',
    ];
}
