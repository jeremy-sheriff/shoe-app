<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class CartController extends Controller
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function add(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'color' => 'required|in:black,white,red,blue,custom',
            'sizes' => 'required',
        ]);

        $product = Product::with('images')->findOrFail($id);
        $quantity = $request->input('quantity', 1);
        $size = $request->input('sizes', 1);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;

        } else {
            $cart[$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->images->first()->path ?? 'default.jpg',
                'quantity' => $quantity,
                'color' => $request->input('color'),
                'product' => $product,
                'sizes' => $size,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function increase($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += 1;
            session()->put('cart', $cart);
        }

        return redirect()->back();
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function decrease($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            if ($cart[$id]['quantity'] > 1) {
                $cart[$id]['quantity'] -= 1;
            } else {
                unset($cart[$id]);
            }

            session()->put('cart', $cart);
        }

        return redirect()->back();
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back();
    }
}
