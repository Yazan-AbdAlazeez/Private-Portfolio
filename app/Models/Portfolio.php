<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'profile_image'
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function works() { return $this->hasMany(Work::class); }
    public function about() { return $this->hasOne(About::class); }
    public function services() { return $this->hasMany(Service::class); }
    public function contact() { return $this->hasOne(Contact::class); }
    public function socialLinks() { return $this->hasMany(SocialLink::class); }

    public function getImageUrlAttribute(){
        if($this->profile_image){
            return url("$this->profile_image");
        }
        return null;
    }
}
