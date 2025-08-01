<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index(){
        $faqs = DB::table('faqs')->get();
        return view('admin.faqs.index',compact('faqs'));
    }

    public function create(){
        return view('admin.faqs.create');
    }

    public function store(Request $req){
        $faq = DB::table('faqs')->insert([
            'question' => $req->question,
            'answer' => $req->answer,
            'status' => $req->status,
        ]);
        return redirect()->route('faqs')->with('success','FAQ created successfully.');
    }

    public function edit($id){
        $faq = DB::table('faqs')->where('id',$id)->first();
        return view('admin.faqs.edit',compact('faq'));
    }

    public function update(Request $req){
        $faq = DB::table('faqs')->where('id',$req->faq_id)->update([
            'question' => $req->question,
            'answer' => $req->answer,
            'status' => $req->status,
        ]);
        return redirect()->route('faqs')->with('success','FAQ updated successfully.');
    }

    public function delete($id){
        $faq = DB::table('faqs')->where('id',$id)->delete();
        return redirect()->route('faqs')->with('success','FAQ deleted successfully.');
    }
}
