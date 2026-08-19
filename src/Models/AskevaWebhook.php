<?php

namespace Askeva\WhatsApp\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AskevaWebhook extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'askeva_webhooks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'message_id',
        'from_wa_id',
        'from_name',
        'business_phone_number_id',
        'display_phone_number',
        'body',
        'raw_payload',
        'received_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'raw_payload' => 'array',
        'received_at' => 'datetime',
    ];
}
