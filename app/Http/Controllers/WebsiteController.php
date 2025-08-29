<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\Property;
use App\Models\Gallery;

use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function home(){
        $faqs = DB::table('faqs')->where('status','Active')->get();
        $properties = Property::orderBy('published_at','DESC')->where('status','!=','Pending')->where('status','!=','Inactive')->where('status','!=','Rejected')->limit(6)->get();
        return view('website.home',compact('faqs','properties'));
    }

    public function about_us(){
        return view('website.about_us');
    }

    public function contact_us(){
        return view('website.contact_us');
    }

    public function properties(){
        $countries = DB::table('countries')->get();
        $types = DB::table('property_types')->get();
        $properties = Property::orderBy('published_at','DESC')->where('status','!=','Pending')->where('status','!=','Inactive')->where('status','!=','Rejected')->paginate(9);
        return view('website.properties',compact('properties','countries','types'));
    }

    public function search_properties(Request $request)
{
    $query = Property::query();

    // Status filter
    $query->whereNotIn('status', ['Pending', 'Inactive', 'Rejected']);

    // Filters
    if ($request->filled('country')) {
        $query->where('country', $request->country);
    }

    if ($request->filled('state')) {
        $query->where('state', $request->state);
    }

    if ($request->filled('city')) {
        $query->where('city', $request->city);
    }

    if ($request->filled('type')) {
        $query->where('type', $request->type);
    }

    // Price filter
    if ($request->filled('max_price')) {
        if ($request->max_price == '5000000+') {
            $query->where('price', '>=', 5000000);
        } else {
            $query->where('price', '<=', (int) $request->max_price);
        }
    }
    // Order by logic
    if ($request->filled('order_by')) {
        switch ($request->order_by) {
            case 'high_to_low':
                $query->orderBy('price', 'desc');
                break;
            case 'low_to_high':
                $query->orderBy('price', 'asc');
                break;
            case 'latest':
            default:
                $query->orderBy('published_at', 'desc');
                break;
        }
    } else {
        // No order_by selected
        if ($request->filled('max_price')) {
            $query->orderBy('price', 'desc'); // default if price range selected
        } else {
            $query->orderBy('published_at', 'desc'); // default
        }
    }

    $properties = $query->paginate(9)->appends($request->all());
    $countries = DB::table('countries')->get();
    $types = DB::table('property_types')->get();
    return view('website.properties', compact('properties', 'countries', 'types'));
}

    public function get_states(Request $req){
        $states = DB::table('states')->where('country_id',$req->country_id)->get();
        return response()->json(['data' => $states]);
    }

    public function get_cities(Request $req)
    {
        $cities = DB::table('cities')->where('state_id',$req->state_id)->get();
        return response()->json(['data' => $cities]);
    }

    public function property_detail($id){
        $property = Property::where('id',$id)->first();
        $images = Gallery::where('property_id',$property->id)->where('file_type','Image')->get();
        $videos = Gallery::where('property_id',$property->id)->where('file_type','Video')->get();
        return view('website.property_detail',compact('property','images','videos'));
    }

    public function store_contact_us(Request $req){
        $data = DB::table('feedbacks')->insert([
            'name' => $req->name,
            'email' => $req->email,
            'phone' => $req->phone,
            'type' => $req->type,
            'message' => $req->message,
        ]);
        return redirect()->back()->with('success','Message submitted successfully! We will get back to you soon.');
    }
}
