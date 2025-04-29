<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'portfolio_id',
        'email',
        'phone',
        'address',
        'additional_info',
    ];

    public function portfolio() { return $this->belongsTo(Portfolio::class); }
}
