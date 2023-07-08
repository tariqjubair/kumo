<?php

namespace App\Http\Controllers;

use App\Models\FaqTab;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FaqCont extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $faq_all = FaqTab::orderBy('order')->get();
        return view('admin.faq.faq_list', [
            'faq_all' => $faq_all,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.faq.add_faq');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'order' => 'required',
            'question' => 'required',
            'answer' => 'required',
        ], [
            'order.required' => 'Please insert showing order!',
            'question.required' => 'Please insert a Question!',
            'answer.required' => 'Please insert your Answer!',
        ]);
        // return $request->all();

        FaqTab::insert([
            'order' => $request->order,
            'question' => $request->question,
            'answer' => $request->answer,
            'created_at' => Carbon::now(),
        ]);
        return back()->with('job_upd', 'New FAQ Added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $faq_info = FaqTab::find($id);
        return view('admin.faq.edit_faq', [
            'faq_id' => $id,
            'faq_info' => $faq_info,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'order' => 'required',
            'question' => 'required',
            'answer' => 'required',
        ], [
            'order.required' => 'Field cannot be Blank!',
            'question.required' => 'Field cannot be Blank!',
            'answer.required' => 'Field cannot be Blank!',
        ]);
        // return $request->all();

        FaqTab::find($id)->update([
            'order' => $request->order,
            'question' => $request->question,
            'answer' => $request->answer,
        ]);
        return back()->with('job_upd', 'FAQ Item Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        FaqTab::find($id)->delete();
        return back()->with('del', 'FAQ Item Deleted!');
    }
}
