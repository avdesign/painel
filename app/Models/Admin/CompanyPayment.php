<?php

namespace AVDPainel\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class CompanyPayment extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'billet',
        'cash',
        'credit_card',
        'debit_card'
    ];
}
