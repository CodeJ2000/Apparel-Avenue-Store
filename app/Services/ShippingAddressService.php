<?php
namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ShippingAddressService {

    protected $user;


    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function getUserShippingAddress()
    {
       $user = Auth::user();
       
       try{
            $shippingAddress = $user->shippingAddress;
            if($shippingAddress){
               $street = $shippingAddress->street;
               $barangay = $shippingAddress->barangay;
               $city = $shippingAddress->city;
               $province = $shippingAddress->province;
               $postal_code = $shippingAddress->postal_code;
               
               $address = $street . ", " . $barangay . ", " . $city . ", " . $province . " " . $postal_code;
               return ucwords($address);
            }
            return "No Shipping address yet.";
       } catch(Exception $e){
            Log::error('An error occured at:' . $e->getMessage());
       }
    }
}