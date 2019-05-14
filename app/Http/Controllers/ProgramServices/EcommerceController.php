<?php 

namespace App\Http\Controllers\ProgramServices;

use App\Helpers\ActivationCodeHelperClass;
use App\Http\AbstractHandlers\MemberAbstract;
use App\Models\Branches;
use App\Models\Products;
use App\Models\User;

use Illuminate\Http\Request;
use Session;

class EcommerceController extends MemberAbstract 
{
	function __construct(){
        parent::__construct();
    }

	/**
	 * Display the specified resource.
	 *
	 * @param  Products  $products
	 * @return Response
	 */
	public function show(Products $products)
	{
		return view('ecommerce.show', $products);
	}

	/**
	 * Add to cart.
	 *
	 * @param  Request   $request
	 * @param  Products  $products
	 * @return Response
	 */
	public function addToCart(Request $request, Products $product)
	{
		try{
			if (!$request->session()->has('cart')) {
				$request->session()->put('cart', []);
			}

			if (!$request->session()->has('cart.'.$product->slug)) {
				$request->session()->put('cart.'.$product->slug, []);
			}
			
			$quantity = $request->quantity? $request->quantity: 1;
			
			$request->session()->put('cart.'.$product->slug, [
				'id'		   => $product->id,
				'quantity'     => $quantity,
				'member_price' => $product->rebates,
				'srp'          => $product->price,
				'name'         => $product->name,
				'image'        => $product->image,
			]);

			return response()->json(['success' => 'true']);
		} catch(\Exception $e) {
			return response()->json(['success' => 'false']);
		}
	}

	/**
	 * Display cart.
	 *
	 * @return Response
	 */
	public function cart()
	{
		$products = Session::has('cart')? Session::get('cart'): null;
		
		return view('ecommerce.cart', [ 'products' => $products ]);
	}

	/**
	 * Remove item from cart.
	 *
	 * @return Response
	 */
	public function removeFromCart($productSlug)
	{
		try{
			Session::forget('cart.'. $productSlug);
			Session::save();

			return Session::has('cart.'. $productSlug)? 
				response()->json(['success' => 'false']): 
				response()->json(['success' => 'true']);
		} catch( \Exception $e) {
			return response()->json(['success' => 'false']);
		}
	}

	/**
	 * Update item from cart.
	 *
	 * @return Response
	 */
	public function updateCart(Request $request)
	{
		try{
			foreach ($request->products as $slug => $product) {
				Session::put('cart.'. $slug. '.quantity', $product['quantity']);
				Session::save();
			}
			return response()->json(['success' => 'true']);
		} catch( \Exception $e) {
			return response()->json(['success' => 'false']);
		}
	}

	/**
	 * Display place order page.
	 * (The page after)
	 *
	 * @return Response
	 */
	public function placeOrder()
	{
		$products = Session::has('cart')? Session::get('cart'): null;
		$branches = Branches::get();
		$totalPurchase = 0.00;

		foreach ($products as $slug => $product) {
			$this->codesToGenerate = $product['quantity'];
			$this->productID       = $product['id'];

			if (!isset($products[$slug]['codes'])) {
				$products[$slug]['codes'] = [];
				$products[$slug]['codes'] = $this->generatePurchaseCodes();
				
				Session::put('cart.'. $slug. '.codes', $products[$slug]['codes']);
				Session::save();
			}

			if (sizeOf($products[$slug]['codes']) < $product['quantity']) {
				$this->codesToGenerate    = $product['quantity'] - sizeOf($products[$slug]['codes']);
				$products[$slug]['codes'] = $this->generatePurchaseCodes();

				foreach ($products[$slug]['codes'] as $key => $code) {
					Session::push('cart.'. $slug. '.codes', $code);
					Session::save();
				}
			} else if (sizeOf($products[$slug]['codes']) > $product['quantity']) {
				$removeCodeCount = sizeOf($products[$slug]['codes']) - $product['quantity'];

				while ($removeCodeCount--) {
					Session::pull('cart.'. $slug. '.codes');
					Session::save();
				};
			}

			$totalPurchase = $totalPurchase + ($product['quantity'] * $product['member_price']);
		}
		
		return view('ecommerce.place_order', [
			'products'      => $products,
			'totalPurchase' => $totalPurchase,
			'branches'      => $branches
		]);
	}

	/**
	 * Calls generateCode helper.
	 *
	 * @return Array
	 */
	private function generatePurchaseCodes()
	{
		$codes = new ActivationCodeHelperClass();
		
        $codes->setBatchID($this->batchID)
            ->setCodeType($this->type)
            ->setNumOfZeros($this->numberOfZeros)
            ->setPatternEveryLetter($this->patternEveryLetter)
            ->setPrefixLength($this->prefixLength)
            ->setOwnerID($this->theUser->id)
            ->setProductID($this->productID);

        return $codes->generateCodes(
        	$this->codesToGenerate,
        	User::find($this->theUser->id)->member_type_id,
        	User::find($this->theUser->id)->username
        );
	}
}