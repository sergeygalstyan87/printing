<?php

namespace App\Models;

use App\Notifications\VerifyEmail;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'company',
        'address',
        'password',
        'role_id',
        'unit',
        'zip',
        'city',
        'state',
        'stripe_customer_id',
        'stripe_card_ids'
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
        'stripe_card_ids' => 'array',
    ];

    public function orders(){
        return $this->hasMany(Order::class, 'user_id', 'id');
    }

    public function addresses(){
        return $this->hasMany(Address::class, 'user_id', 'id');
    }
    public function basket(){
        return $this->hasone(Basket::class);
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }
    public function getSavedCards()
    {
        $stripe = Stripe::setApiKey(env('STRIPE_SECRET'));
        $cards = [];
        if($id = $this->stripe_customer_id){
            $cards_list = $stripe->cards()->all($id);
            foreach ($cards_list['data'] as $card){

                $customer = $stripe->customers()->find($id);
                $default_card_id = $customer ? $customer['default_source'] : null;

                $cards[] = [
                    'id'=>$card['id'],
                    'brand' => $card['brand']=='American Express' ? 'amex' : strtolower($card['brand']),
                    'last4' => $card['last4'],
                    'exp_month' => $card['exp_month'],
                    'exp_year' => $card['exp_year'],
                    'default_card' => $card['id'] == $default_card_id,
                ];
            }
        }

        return $cards;
    }

}
