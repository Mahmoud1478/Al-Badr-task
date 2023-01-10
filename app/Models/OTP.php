<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class OTP extends Model
{
    use HasFactory;
    protected $table = 'otps';
    protected $fillable = ['client_id','code'];

    public function check(string $OTP): bool
    {
        return $OTP == $this->attributes['code'];
    }
    protected static function boot()
    {
        parent::boot();
        OTP::creating(function (OTP $model){
            $model->setAttribute('code',Str::random(5));
        });
    }
}
