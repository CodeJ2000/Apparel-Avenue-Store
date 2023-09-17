<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
 
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getFirstNameAttribute($value)
    {
        return ucwords($value);
    }

    public function getLastNameAttribute($value)
    {
        return ucwords($value);
    }
    //user can have one shipping address
    public function shippingAddress()
    {
        return $this->hasOne(ShippingAddress::class);
    }

    //return the users data except the user with admin role
    public static function getUsersData()
    {
        $customerRole = Role::where('name', 'customer')->first(); //get the role 'customer'
        return self::select(['id','first_name', 'last_name', 'email', 'created_at'])
                        ->whereHas('roles', function($query) use ($customerRole){
                            $query->where('roles.id' , $customerRole->id);//get the user where the roles id match the customer role id
                        });
    }
}