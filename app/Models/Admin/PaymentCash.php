<?php

namespace AVDPainel\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class PaymentCash extends Model
{
    protected $fillable = [
        'order_id',
        'user_id',
        'company_name',
        'method_payment',
        'status',
        'status_label',
        'reference',
        'code',
        'value',
        'date',
        'date_refersh_status'
    ];
}
