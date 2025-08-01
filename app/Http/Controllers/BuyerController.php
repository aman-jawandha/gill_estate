<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Property;

class BuyerController extends Controller
{
public function fav_property(Request $request){
    $user = auth()->user();
    $propertyId = $request->property_id;

    $favourites = explode(',', $user->favourites ?? '');
    $favourites = array_filter($favourites);

    if (in_array($propertyId, $favourites)) {
        $favourites = array_diff($favourites, [$propertyId]);
    } else {
        $favourites[] = $propertyId;
    }
    $user->favourites = implode(',', $favourites);
    $user->save();

    return response()->json([
        'success' => true,
        'favourites' => $favourites,
    ]);
}

public function fav_properties(Request $request){
    $favourites = explode(',', auth()->user()->favourites ?? '');
    $favourites = array_filter($favourites);
    $properties = Property::whereIn('id', $favourites)->paginate(6);
    return view('buyer.favourite_properties', compact('properties'));
}

public function find_property(){
    $types = DB::table('property_types')->get();
    $requirements = DB::table('buyers_requirements')->where('user_id',auth()->id())->orderBy('id','DESC')->paginate(3);
    return view('buyer.find_property', compact('types','requirements'));
}

public function store_property_requirements(Request $request){
    $data = $request->all();
    unset($data['_token']);
    $data['user_id'] = auth()->id();
    $requirements = DB::table('buyers_requirements')->insert($data);
    return back()->with('success','Preferences submiited successfully');
}

public function delete_property_requirement($id){
    $requirement = DB::table('buyers_requirements')->where('id',$id)->delete();
    return back()->with('success','Property preference deleted successfully');
}
}
