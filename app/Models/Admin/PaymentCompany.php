<?php

namespace AVDPainel\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class PaymentCompany extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'billet',
        'cash',
        'credit',
        'debit'
    ];
}
