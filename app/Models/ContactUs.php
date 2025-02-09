<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    protected $table = 'contact_us';

    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'is_read',
        'is_replied',
        'reply_message',
        'replied_at',
    ];
}
