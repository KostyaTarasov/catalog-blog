<?php

namespace App\Http\Controllers;

use App\Services\Cart;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function store(Request $request, Cart $cart): JsonResponse
    {
        $data = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'qty' => ['required', 'integer', 'min:1', 'max:99'],
        ]);

        $cart->add($data['product_id'], $data['qty']);

        return response()->json(['count' => $cart->count()]);
    }
}
