<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'country_code',
        'province_id',
        'region_id',
        'new_city_id',
        'neighbour_id',
        'account_type',
        'company_name',
        'accept_terms',
        'address',
        'whatsapp_number',
        'fax',
        'zip_code',
        'your_website_url',
        'facebook_url',
        'twitter_url',
        'linked_in_url',
        'ebay_url',
        'profile_photo'
    ];

    public function childs()
    {
        return $this->hasMany(Region::class, 'parent_id', 'id');
    }

    // public function parent()
    // {
    //     return $this->hasMany(Country::class, 'id', 'parent_id');
    // }
}
