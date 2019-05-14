<?php 

namespace App\Http\Modules\Admin\Products\Controllers;

use App\Http\AbstractHandlers\AdminAbstract;
use App\Http\Modules\Admin\Products\Validation\ProductValidationHandler;
use App\Http\Requests;
use App\Http\TraitLayer\ProductsTrait;
use App\Models\Products;
use App\Models\ProductUnilevel;
use App\Models\PurchaseCodes;
use App\Models\Purchases;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use File;
use Storage;

class ProductsAdminController extends AdminAbstract {

    use ProductsTrait;

    protected $viewpath = 'Admin.Products.views.';

    function __construct(){
        parent::__construct();
    }

    function getIndex(){
        return view($this->viewpath.'index')
            ->with(
                [
                    'products'=>Products::orderBy('id', 'asc')->paginate(50)
                ]
            );
    }

    function getForm($id = 0)
    {
        return view($this->viewpath.'form')
            ->with([
                'product'    => Products::find($id),
                'types'      => Products::TYPES,
                'categories' => Products::CATEGORIES
            ]);
    }

    function postForm(Request $request)
    {
        $rules = [
            'name'         => 'required',
            'slug'         => 'required|string|unique:products,slug,NULL|without_spaces',
            'price'        => 'required|numeric',
            'rebates'      => 'required|numeric',
            'points_value' => 'numeric',
            'description'  => 'required',
            'publish'      => 'required|numeric|in:1,0',
            'type'         => 'required|numeric',
            'category'     => 'required|numeric'
        ];

        if (isset($request['id']) && $request['id'] !== '') {
            $rules = array_merge($rules, [
                'slug'  => 'required|string|unique:products,slug,'.$request->id.'|without_spaces'
            ]);
        }

        $validate = Validator::make($request->all(), $rules);

        if ($validate->fails()) {
            return redirect()
                ->back()
                ->withErrors($validate->errors())
                ->withInput();
        }

        try {
            if (isset($request['id']) && $request['id'] !== '') {
                $product = Products::find($request['id'])->fill($request->except(['id', 'image']));
            } else {
                $product = new Products($request->except(['id', 'image']));
            }
            $product->save();

            if ($request->hasFile('image')) {
                Storage::disk('products')->put(
                    $product->id.'_'.$request->file('image')->getClientOriginalName(), 
                    $request->file('image')
                );

                $product->image = $product->id.'_'.$request->file('image')->getClientOriginalName();
                $product->save();
            }

            return redirect('admin/products')->with('success', Lang::get('products.added'));
        } catch (\Exception $e) {
            return redirect('admin/products')
                ->withErrors($validate->errors())
                ->with('danger', $e);
        }
    }

    function getPurchaseCodes(){
        view()->share([
            'pagename'=>'purchase codes'
        ]);
        return view($this->viewpath.'purchase_codes')
            ->with(
                [
                    'productsDropdown'=>$this->getProductsList()->dropdown,
                    'codes'=>PurchaseCodes::orderBy('status', 'asc')->orderBy('id', 'desc')->paginate(50)
                ]
            );
    }

    function postPurchaseCodes(Request $request, $member_id = 0){
        $validate = new ProductValidationHandler();
        $validate
            ->setInputs($request->input());

        if ($member_id > 0){
            $validate->setMemberID($member_id);
        }
        $result = $validate->validatePurchaseCodes();

        Session::flash($result->message_type, $result->message);

        return ($result->error) ? back()->withErrors($result->validation->errors())->withInput() : back();

    }

    function getUnilevel($product_id = 0){

        $type = $this->theCompany->product_unilevel;

        $products = Products::all();

        $settings = ($type == 'universal') ? ProductUnilevel::orderBy('level', 'ASC')->get() : ProductUnilevel::where('product_id', $product_id)->orderBy('level', 'ASC')->get();

        $nextLevel = 0;

        foreach ($settings as $row){
            $nextLevel = $row->level;
        }

        $nextLevel += 1;

        return view( $this->viewpath . 'unilevel' )
            ->with([
                'type'=>$type,
                'settings'=>$settings,
                'nextLevel'=>$nextLevel,
                'products'=>$products
            ]);

    }

    function postUnilevel(Request $request, $product_id = 0){

        $result = new \stdClass();
        $result->error = false;
        $result->message = '';

        $type = $this->theCompany->product_unilevel;

        $settings = ($type == 'universal') ? ProductUnilevel::orderBy('level', 'ASC')->get() : ProductUnilevel::where('product_id', $product_id)->orderBy('level', 'ASC')->get();

        $nextLevel = 0;

        foreach ($settings as $row){
            $nextLevel = $row->level;
        }

        $nextLevel += 1;

        if ($request->add_unilevel){

            if ($request->amount == null){
                $result->error = true;
                $result->message = Lang::get('products.amount_required');
            }

            if ($type == 'per_product' and $product_id <= 0){
                $result->error = true;
                $result->message = Lang::get('products.product_required');
            }

            if (!$result->error){

                $unilevel = new ProductUnilevel();
                $unilevel->amount = $request->amount;
                $unilevel->level = $nextLevel;
                $unilevel->product_id = $product_id;
                $unilevel->save();
                $result->message = Lang::get('products.settings_saved');

            }

        } else if ($request->update) {

            $id = $request->id;

            if ($request->amount[$id] == null){
                $result->error = true;
                $result->message = Lang::get('products.amount_required');
            }

            if (!$result->error){

                $unilevel = ProductUnilevel::find($id);
                $unilevel->amount = $request->amount[$id];
                $unilevel->level = $request->level[$id];
                $unilevel->product_id = $request->product_id[$id];
                $unilevel->save();
                $result->message = Lang::get('products.settings_saved');

            }

        }

        return ($result->error) ? redirect('admin/products/unilevel')->withInput()->with([
            'danger'=>$result->message
        ]) : redirect('admin/products/unilevel')->with('success', $result->message);

    }

    function getDelete($id){

        $purchased = Purchases::where('product_id', $id)->get();

        $error = false;
        $message = '';

        if ($purchased->isEmpty()){

            Products::where('id', $id)->delete();
            PurchaseCodes::where('product_id', $id)->delete();
            ProductUnilevel::where('product_id', $id)->delete();
            $message = Lang::get('products.delete_success');

        } else {

            $message = Lang::get('products.cannot_delete');
            $error = true;

        }

        $message_type = ($error) ? 'danger' : 'success';

        return back()->with($message_type, $message);

    }

}
