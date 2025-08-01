<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Property;
use App\Models\Gallery;

class SellerController extends Controller
{
    public function sell_property(){
        $states = DB::table('states')->get();
        $types = DB::table('property_types')->get();
        return view('seller.sell_property',compact('states','types'));
    }

    public function my_properties(){
        $properties = Property::where('user_id',auth()->id())->orderBy('id','DESC')->paginate(2);
        return view('seller.my_properties',compact('properties'));
    }

    public function edit_property($id){
        $states = DB::table('states')->get();
        $types = DB::table('property_types')->get();
        $property = Property::where('id',$id)->first();
        return view('seller.edit_my_property',compact('states','types','property'));
    }

    public function view_property($id){
        $property = Property::where('id',$id)->first();
        $images = Gallery::where('property_id',$property->id)->where('file_type','Image')->get();
        $videos = Gallery::where('property_id',$property->id)->where('file_type','Video')->get();
        return view('seller.view_my_property',compact('property','images','videos'));
    }
}
