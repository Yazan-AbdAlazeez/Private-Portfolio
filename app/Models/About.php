<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;

    protected $fillable = [
        'portfolio_id',
        'content',
    ];

    public function portfolio() { return $this->belongsTo(Portfolio::class); }
}


