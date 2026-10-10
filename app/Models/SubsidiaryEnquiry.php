<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubsidiaryEnquiry extends Model
{
    protected $fillable = [
        'subsidiary_company_id',
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'status',
        'admin_notes',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(SubsidiaryCompany::class, 'subsidiary_company_id');
    }
}
