<?php

namespace App\Http\Controllers\Customer;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\CartRequest;
use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Services\CartItemService;
use App\Services\CartService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    protected $cartService;
    protected $cartItemService;
    public function __construct(CartService $cartService, CartItemService $cartItemService)
    {
        $this->cartService = $cartService;
        $this->cartItemService = $cartItemService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //return the cart page and display the cart items in table
    public function index()
    {
        $cartData = $this->cartService->displayProducts(5);
        return view('customer.cart', compact('cartData'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CartRequest $request)
    {
        //Store new products
        $validated = $request->validated(); // return the Validated request
        $cartMessage = $this->cartService->addOrUpdateItemToCart($validated); //handle the creation of the product
        return response()->json(['message' => $cartMessage]); //Return the success message in json
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     //delete selected item in the cart
    public function destroy(CartItem $cartItem)
    {
        try {

            $cartItem->delete();

            return response()->json(['status' => 200, 'message' => 'Cart item is successfuly deleted']);
        } catch(Exception $e){
            Log::error('An error occured at: ' . $e->getMessage());
        }
    }

    //get single cart item 
    public function getSingleCartItem(CartItem $cartItem)
    {
        $product = $this->cartService->getSingleCartItem($cartItem);
        return response()->json($product);
    }
}