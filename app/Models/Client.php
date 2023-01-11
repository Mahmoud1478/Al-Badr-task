<?php

namespace App\Models;

use App\Classes\Upload;
use App\Jobs\OTPJop;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Client extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'first_name',
        'last_name',
        'mid_name',
        'email',
        'password',
        'phone',
        'latitude',
        'longitude',
        'image',
        'drive_licence',
        'email_verified_at',
        'is_active'
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean'
    ];

    /**
     * @return void
     */
    public function markEmailAsUnverified(): void
    {
        $this->email_verified_at = null;
        $this->save();
    }

    public function send_otp(OTP $OTP)
    {
        dispatch(new OTPJop($this,$OTP));
    }


    /**
     * @return Attribute
     */
    public function fullName() : Attribute
    {
        return Attribute::make(get:function () {
            return preg_replace(
                '/\s\s+/',
                ' ',
                $this->first_name. ' ' . $this->mid_name.' '.$this->last_name
            );
        });
    }

    /**
     * @return string
     */
    public function getImageUrlAttribute()
    {

        return Upload::url($this->image);
    }
    /**
     * @return string
     */
    public function getDriveLicenceUrlAttribute()
    {
        return Upload::url($this->drive_licence);
    }

    /**
     * @return Attribute
     */
    public function password(): Attribute
    {
        return Attribute::set(fn ($value) => bcrypt($value));
    }
    public function otp(): HasOne
    {
        return $this->hasOne(OTP::class);
    }

}
