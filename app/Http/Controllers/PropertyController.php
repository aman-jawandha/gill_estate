<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Gallery;

class PropertyController extends Controller
{
    public function index(){
        $countries = DB::table('countries')->get();
        $types = DB::table('property_types')->get();
        $properties = Property::where('user_role','!=','seller')->orderBy('id','DESC')->paginate(6);
        return view('admin.properties.index',compact('countries','types','properties'));
    }

    public function search(Request $request)
{
    $query = Property::query();
    // Only properties not listed by "seller"
    $query->where('user_role', '!=', 'seller');

    // Status filter (if needed in admin view)
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
        // Default order if nothing selected
        if ($request->filled('max_price')) {
            $query->orderBy('price', 'desc');
        } else {
            $query->orderBy('published_at', 'desc');
        }
    }
    // Paginate and persist filters in pagination
    $properties = $query->paginate(6)->appends($request->all());

    // Optional: Get dropdown data for filters in admin view
    $countries = DB::table('countries')->get();
    $types = DB::table('property_types')->get();
    return view('admin.properties.index', compact('countries', 'properties', 'types'));
}


    public function create(){
        $countries = DB::table('countries')->get();
        $types = DB::table('property_types')->get();
        $statuses = DB::table('property_status')->get();
        return view('admin.properties.create',compact('countries','types','statuses'));
    }

    public function store(Request $req){
        $data = $req->all();
        unset($data['_token']);
        unset($data['files']);
        $data['user_id'] = auth()->id();
        $data['user_role'] = auth()->user()->role;
        if($req->status == 'For Sale' || $req->status == 'For Rent'){
            $data['published_at'] = now();
        }else{
            $data['published_at'] = null;
        }
        if ($req->hasFile('banner_image')) {
            $file = $req->file('banner_image');
            $filename = $file->getClientOriginalName();
            $file->move(public_path('uploads/properties/banner_images'), $filename);
            $data['banner_image'] = $filename;
        }else{
            $data['banner_image'] = null;
        }
        $property = Property::insert($data);
        if(auth()->user()->role == 'seller'){
            return redirect()->route('my-properties')->with('success','Property added successfully');
        }else{
            return redirect()->route('properties-list')->with('success','Property added successfully');
        }
    }

    public function view($id){
        $property = Property::where('id',$id)->first();
        $images = Gallery::where('property_id',$property->id)->where('file_type','Image')->get();
        $videos = Gallery::where('property_id',$property->id)->where('file_type','Video')->get();
        return view('admin.properties.view',compact('property','images','videos'));
    }

    public function edit($id){
        $countries = DB::table('countries')->get();
        $types = DB::table('property_types')->get();
        $statuses = DB::table('property_status')->get();
        $property = Property::where('id',$id)->first();
        return view('admin.properties.edit',compact('countries','types','statuses','property'));
    }

    public function update(Request $req){
        $data = $req->all();
        unset($data['_token']);
        unset($data['files']);
        unset($data['property_id']);
        if(auth()->user()->role == 'seller'){
            $data['status'] = 'Pending';
        }
        if($req->status == 'For Sale' || $req->status == 'For Rent'){
            $data['published_at'] = now();
        }else{
            $data['published_at'] = null;
        }
        if ($req->hasFile('banner_image')) {
            $file = $req->file('banner_image');
            $filename = $file->getClientOriginalName();
            $file->move(public_path('uploads/properties/banner_images'), $filename);
            $data['banner_image'] = $filename;
        }
        $property = Property::where('id',$req->property_id)->update($data);
        return redirect()->back()->with('success','Property updated successfully');
    }

    public function delete($id){
        $property_id = $id;
        $property = Property::where('id',$property_id)->delete();
        $media = Gallery::where('property_id',$property_id)->delete();
        if(auth()->user()->role == 'seller'){
            return redirect()->route('my-properties')->with('success','Property deleted successfully');
        }else{
            return redirect()->route('properties-list')->with('success','Property deleted successfully');
        }
    }

    public function store_property_images(Request $req)
{
    if($req->image_id && $req->image_id != null && $req->hasFile('image')){
            $file = $req->file('image');
            $filename = $file->getClientOriginalName();
            $file->move(public_path('uploads/properties/images'), $filename);
            $image = Gallery::where('id',$req->image_id)->update([
                    'file' => $filename,
                ]);
        return redirect()->back()->with('success', 'Image updated successfully.');
    }
    if ($req->hasFile('images')) {
        $files = $req->file('images');
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];

        // Take only first 5 images
        $files = array_slice($files, 0, 5);

        foreach ($files as $file) {
            $extension = strtolower($file->getClientOriginalExtension());
            if (!in_array($extension, $allowedExtensions)) {
                continue; // Skip files with invalid extensions
            }

            $filename = $file->getClientOriginalName();
            $file->move(public_path('uploads/properties/images'), $filename);

            Gallery::insert([
                'property_id' => $req->property_id,
                'file' => $filename,
                'file_type' => 'Image',
            ]);
        }
        return redirect()->back()->with('success', 'Images uploaded successfully.');
    } else {
        return redirect()->back()->with('error', 'No images were uploaded.');
    }
}

    public function store_property_video(Request $req){
        if ($req->hasFile('video')) {
            $file = $req->file('video');
            $filename = $file->getClientOriginalName();
            $file->move(public_path('uploads/properties/videos'), $filename);
            if($req->video_id && $req->video_id != null){
                $video = Gallery::where('id',$req->video_id)->update([
                    'file' => $filename,
                ]);
            }else{
                $video = Gallery::insert([
                    'property_id' => $req->property_id,
                    'file' => $filename,
                    'file_type' => 'Video',
                ]);
            }
            return redirect()->back()->with('success','Video uploaded successfully.');
        }else{
            return redirect()->back()->with('error','Something went wrong!');
        }
    }

    public function delete_property_media($id){
        $media = Gallery::where('id',$id)->delete();
        return redirect()->back()->with('success','Media deleted successfully.');
    }

    public function buyers_requirements(){
        $requirements = DB::table('buyers_requirements')->where('status','Active')->orderBy('id','DESC')->paginate(12);
        return view('admin.properties.requirements',compact('requirements'));
    }

    public function delete_requirement($id){
        $requirement = DB::table('buyers_requirements')->where('id',$id)->update(['status'=>'Inactive']);
        return redirect()->back()->with('success','Requirement deleted successfully.');
    }

    public function sellers_properties(){
        $properties = Property::where('user_role','seller')->orderBy('updated_at','DESC')->paginate(6);
        return view('admin.properties.sellers_properties',compact('properties'));
    }

    public function reject_property(Request $req){
        $property = Property::where('id',$req->seller_property_id)->first();
        $property->status = 'Rejected';
        $property->reason = $req->reason;
        $property->save();
        return redirect()->back()->with('success','Property Rejected Successfully.');
    }
}
