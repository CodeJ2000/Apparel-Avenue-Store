<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Models\ShippingAddress;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ShippingAddressRequest;
use Exception;
use Illuminate\Support\Facades\Log;

class ShippingAddressController extends Controller
{
    
    public function addOrUpdate(ShippingAddressRequest $request)
    {
        $validated = $request->validated();

        $user = Auth::user();
        $shippingAddress = $user->shippingAddress;
        
        DB::beginTransaction();
        
        try {
            if($shippingAddress){
                $shippingAddress->update($validated);

            } else {
                ShippingAddress::create([
                    'user_id' => $user->id,
                    'street' => $validated['street'],
                    'barangay' => $validated['barangay'],
                    'city' => $validated['city'],
                    'province' => $validated['province'],
                    'postal_code' => $validated['postal_code'],
                ]);
            }
            DB::commit();
            return response()->json(['message' => 'Successfuly set the shipping address!']);
        } catch(Exception $e) {
            DB::rollBack();
            Log::error('An error occured at: ' . $e->getMessage());

        }
        
    }
}