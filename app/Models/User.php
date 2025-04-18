<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Spatie\MediaLibrary\HasMedia;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Laravolt\Indonesia\Models\City as IndonesiaCity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravolt\Indonesia\Models\Village as IndonesiaVillage;
use Laravolt\Indonesia\Models\District as IndonesiaDistrict;
use Laravolt\Indonesia\Models\Province as IndonesiaProvince;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasUuids, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'company_name',
        'email',
        'email_verified_at',
        'password',
        'avatar',
        'type',
        'status',
        'founded_year',
        'company_address',
        'company_phone',
        'company_website',
        'contact_name',
        'contact_phone',
        'contact_department',
        'contact_position',
        'contact_email',
        'business_type',
        'total_employee',
        'printing_line_total',
        'process_printing',
        'process',
        'anual_turnover',
        'film_production',
        'joined_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'joined_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        return $this->avatar ? asset('storage/user') . '/' . $this->avatar : 'https://via.placeholder.com/150x150.png';
    }
    public function getFormattedJoinedAtAttribute()
    {
        return $this->joined_at ? date('d-m-Y', strtotime($this->joined_at)) : '-';
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }
}

