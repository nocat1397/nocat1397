<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Banner;
use App\Coupon;
use App\Review;
use App\Category;
use App\Designer;
use Carbon\Carbon;
use App\HomeProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LinkController extends Controller
{
    public function home() {
        $banners = Banner::first();
        $coupons = Coupon::all();
        $reviews = Review::where('status','!=',0)->where('message','!=',null)->get();
        $categories = Category::with('product')->has('product')->orderBy('sequence','ASC')->get();
        $sec1 = HomeProduct::where('id',1)->with('product')->first();
        $sec2 = HomeProduct::where('id',2)->with('product')->first();
        $sec3 = HomeProduct::where('id',3)->with('product')->first();
        $sec4 = HomeProduct::where('id',4)->has('product')->first();
        // return $sec1;
        return view('front-end.home', compact('banners','coupons','categories','sec1','sec2','sec3','sec4','reviews'));
    }
    public function about() {
        $categories = Category::with('product')->has('product')->orderBy('sequence','ASC')->get();
        return view('front-end.about' ,compact('categories'));
    }
    public function contact() {
        $categories = Category::with('product')->has('product')->orderBy('sequence','ASC')->get();
        return view('front-end.contact' ,compact('categories'));
    }
    public function terms() {
        $categories = Category::with('product')->has('product')->orderBy('sequence','ASC')->get();
        return view('front-end.terms' ,compact('categories'));
    }
    public function privacy() {
        $categories = Category::with('product')->has('product')->orderBy('sequence','ASC')->get();
        return view('front-end.privacy' ,compact('categories'));
    }
    public function return() {
        $categories = Category::with('product')->has('product')->orderBy('sequence','ASC')->get();
        return view('front-end.return' ,compact('categories'));
    }
    public function faq() {
        $categories = Category::with('product')->has('product')->orderBy('sequence','ASC')->get();
        return view('front-end.faq' ,compact('categories'));
    }
    public function mycart() {
        $categories = Category::with('product')->has('product')->orderBy('sequence','ASC')->get();
        $user = Auth::user();
        $carts = Cart::where('user_id',$user->id)->get();
        $amount = Cart::where('user_id',$user->id)->pluck('amount')->toArray();
        $total = array_sum($amount);
        // return array_sum($amount);
        return view('front-end.purchaser.cart', compact('user','carts','total','categories'));
    }
    
    public function fileUpload($id) {
        $categories = Category::with('product')->has('product')->orderBy('sequence','ASC')->get();
        $cart = Cart::find($id);
        if($cart->amount < 100)
        {
            $priority = 37.99;
            $express = 25.99;
            $standard = 21.99;
            $saver = 15.99;
        }
        if($cart->amount >= 100 && $cart->amount < 200)
        {
            $priority = 55.99;
            $express = 46.99;
            $standard = 36.99;
            $saver = 11.99;
        }
        if($cart->amount >= 200 && $cart->amount < 300)
        {
            $priority = 76.99;
            $express = 59.99;
            $standard = 48.99;
            $saver = 9.99;
        }
        if($cart->amount >= 300 && $cart->amount < 400)
        {
            $priority = 89.99;
            $express = 71.99;
            $standard = 54.99;
            $saver = 5.99;
        }
        if($cart->amount >= 400)
        {
            $priority = $cart->amount*30/100;
            $express = $cart->amount*25/100;
            $standard = $cart->amount*20/100;
            $saver = 0;
        }
        // return $priority;
        return view('front-end.purchaser.upload', compact('cart','categories','priority','express','standard','saver'));
    }
    public function sampleCheckout($id) {
        $categories = Category::with('product')->has('product')->orderBy('sequence','ASC')->get();
        $cart = Cart::find($id);
        return view('front-end.purchaser.samplekitCheckout', compact('cart','categories'));
    }
    public function designer($id) {
        $categories = Category::with('product')->has('product')->orderBy('sequence','ASC')->get();
        $cart = Cart::find($id);
        $desc = Designer::where('cart_id',$id)->first();
        return view('front-end.purchaser.hireDesigner', compact('cart','desc','categories'));
    }
    public function banners()
    {
        $banners = Banner::first();
        return view('admin.banner.addBanner', compact('banners'));
    }
    public function bannerStore(Request $request)
    {
        // return $request;
        $banner = new Banner;
        if ($files = $request->file('header')) 
        {
            foreach ($files as $file) 
            {
                $name=$file->getClientOriginalName();
                $file->move('img/banners/header/', $name);
                $names[] = $name;
            }
            $banner->header = $names;
        }
        if ($file = $request->file('footer')) 
        {
            $footer=$file->getClientOriginalName();
            $file->move('img/banners/footer/', $footer);
            $banner->footer = $footer;
        }
        $banner->save();
        return redirect()->back();
    }
    public function header(Request $request)
    {
        // return $request;
        $file = $request->file('header');
        $name=$file->getClientOriginalName();
        $file->move('img/banners/header/', $name);

        $banner = Banner::find($request->id);
        $images=$banner->header;
        $replaceImage = array($request->key => $name);
        $image = array_replace($images, $replaceImage);
        $banner->header = $image;
        $banner->save();
        return redirect()->back();
    }
    public function footer(Request $request)
    {
        // return $request;
        $file = $request->file('footer');
        $name=$file->getClientOriginalName();
        $file->move('img/banners/footer/', $name);

        $banner = Banner::find($request->id);
        $banner->update(['footer'=>$name]);
        $banner->save();
        return redirect()->back();
    }
    public function coupon()
    {
        return view('admin.coupon.addCoupon');
    }
    public function couponStore(Request $request)
    {
        $coupon = new Coupon;
        $coupon->category = $request->category;
        $coupon->code = $request->code;
        $coupon->discount = $request->discount;
        $coupon->expiry = $request->expiry;
        $coupon->save();

        return redirect()->back()->with('message','Coupon Added Successfully.');
    }
    public function couponUpdate(Request $request)
    {
        $coupon = Coupon::find($request->id);
        $coupon->update(['code'=>$request->code,'category'=>$request->category,'discount'=>$request->discount,'expiry'=>$request->expiry]);
        $coupon->save();

        return redirect()->back()->with('message','Coupon Updated Successfully.');
    }
    public function couponDelete($id)
    {
        $coupon = Coupon::find($id);
        $coupon->delete();

        return redirect()->back()->with('message','Coupon Deleted Successfully.');
    }
    public function showCoupon()
    {
        $coupons = Coupon::all();
        return view('admin.coupon.showCoupon', compact('coupons'));
    }
    public function couponCheck(Request $request)
    {
        $coupon = Coupon::where('code',$request->code)->first();
        // return $request;
        $date = Carbon::now()->format("Y-m-d");
        if($coupon !== null && $coupon->expiry >= $date && $coupon->category == $request->category)
        {
            return $coupon;
        } else {
            return "0";
        }
    }
    public function autocomplete(Request $request)
    {
        // return $request->q;
        $input = $request->q;
        $data = array(
            'Custom Business Card',
            'Slim Business Card',
            'Square Business Card',
            'Raised UV Business Card',
            'Raised Foils Business Card',
            'Linen Business Card',
            'Cotton Business Card',
            'Rendezvous Business Card',
            'Custom Shape Business Card',
            'Custom Vinly Banner',
            'Vinly Eco Frindly Banner',
            'Backlit Banner',
            'Vinly Mesh Banner',
            'Vinly Billboard Banner',
            'Premium Quality Banner',
            '10 Envelops',
            'A6 Envelopsr',
            '9 x 12 Envelops',
            '9 Envelops',
            'A2 Envelops',
            'A7 Envelops',
            '6 x 9 Envelops',
            'Letterhead',
            'Large Folders',
            'Mini Folders',
            'Key Card Holder',
            'Rollup Banner Stand',
            'Deluxe Wide Base Single Sided Banner Stand',
            'Deluxe Wide Base Double Sided Banner Stand',
            'Static X Banner Stand',
            'Multifunctional X Banner Adjustable Stand',
            'Adjustable X Banner Stand',
            'SEG Fabric Frames',
            'Clip Frame',
            'Poster Frame',
            'Aluminum A Frame',
        );
        $links = array(
            '/business-cards/standard-business-cards/custom-business-card',
            '/business-cards/standard-business-cards/slim-business-card',
            '/business-cards/standard-business-cards/square-business-card',
            '/business-cards/standard-business-cards/raised-uv-business-card',
            '/business-cards/standard-business-cards/raised-foils-business-card',
            '/business-cards/standard-business-cards/linen-business-card',
            '/business-cards/standard-business-cards/cotton-business-card',
            '/business-cards/standard-business-cards/rendezvous-business-card',
            '/business-cards/standard-business-cards/custom-shape-business-card',
            '/banners/custom-vinyl-banner',
			'/banners/vinyl-eco-friendly-banner',
			'/banners/backlit-banner',
			'/banners/vinyl-mesh-banner',
			'/banners/vinyl-billboard-banner',
			'/banners/premium-quality-banner',
            '/office-stationary/envelopes/10-envelope',
			'/office-stationary/envelopes/a6-envelope',
			'/office-stationary/envelopes/9x12-envelope',
			'/office-stationary/envelopes/9-envelope',
			'/office-stationary/envelopes/a2-envelope',
			'/office-stationary/envelopes/a7-envelope',
			'/office-stationary/envelopes/6x9-envelope',
            '/office-stationary/letterhead',
            '/office-stationary/folders/large-folders',
            '/office-stationary/folders/mini-folders',
            '/office-stationary/folders/key-card-holder',
            '/stand-display/rollup-banner-stand',
            '/stand-display/deluxe-wide-base-single-sided-banner-stand',
            '/stand-display/deluxe-wide-base-double-sided-banner-stand',
            '/stand-display/static-x-banner-stand',
            '/stand-display/multifunctional-x-banner-adjustable-stand',
            '/stand-display/adjustable-x-banner-stand',
            '/stand-display/seg-fabric-frame',
            '/stand-display/clip-frame',
            '/stand-display/poster-frame',
            '/stand-display/aluminum-a-frame',
        );
        $result = array_filter($data, function ($item) use ($input) {
            if (stripos($item, $input) !== false) {
                return true;
            }
            return false;
        });
        $resultLink = array_filter($links, function ($item2) use ($input) {
            if (stripos($item2, $input) !== false) {
                return true;
            }
            return false;
        });
        
        // return $result;
        $output = '<ul class="dropdown-menu productDropdown" style="display:block; position:relative; padding:10px; height: 500px; overflow-y: auto;">';
      foreach($result as $key=>$row)
      {
       $output .= '<li><a href="'.$resultLink[$key].'">'.$row.'</a></li>
       ';
      }
      $output .= '</ul>';
      echo $output;
        // return response()->json($data);
    }
}
