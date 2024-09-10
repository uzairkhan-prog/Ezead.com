<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jobs_user extends Model
{
    use HasFactory;
	protected $connection= 'jobs_database';
	protected $table = 'users';
	protected $fillable = [
		'country_code',
		'language_code',
		'user_type_id',
		'gender_id',
		'name',
		'photo',
		'about',
		'auth_field',
		'email',
		'phone',
		'phone_national',
		'phone_country',
		'phone_hidden',
		'username',
		'password',
		'remember_token',
		'can_be_impersonate',
		'disable_comments',
		'ip_addr',
		'provider',
		'provider_id',
		'email_token',
		'phone_token',
		'email_verified_at',
		'phone_verified_at',
		'accept_terms',
		'accept_marketing_offers',
		'time_zone',
		'blocked',
		'closed',
		'last_activity',
	];
}
