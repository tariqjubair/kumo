<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Intervention\Image\Facades\Image;
use App\Models\SiteinfoTab;
use Illuminate\Http\Request;

class SiteinfoCont extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $site_info = SiteinfoTab::where('id', 1)->first();
        return view('admin.site.site_info', [
            'site_info' => $site_info,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'site_name' => 'required',
            'site_email' => 'required',
            'site_ph_code' => 'required',
            'site_phone' => 'required',
            'site_add2' => 'required',
            'site_add2' => 'required',
        ]);

        $id = 1;
        $site_info = SiteinfoTab::find($id);

        if($request->site_icon){
            $request->validate([
                'site_icon' => 'mimes:png,jpg|max:1024',
            ]);

            if($site_info->site_icon == 'site_icon.jpg' || $site_info->site_icon == 'site_icon.png'){
                $del_old_image = public_path('assets/img/logo/'. $site_info->site_icon);
                unlink($del_old_image);
            }

            $upl_file = $request->site_icon;
            $ext = $upl_file->getClientOriginalExtension();
            $file_name = 'site_icon.'.$ext;
            Image::make($upl_file)->resize(50, 50)->save(public_path('assets/img/logo/'. $file_name));

            SiteinfoTab::find($id)->update([
                'site_icon' => $file_name,
            ]);
        }

        if($request->site_logo){
            $request->validate([
                'site_logo' => 'mimes:png,jpg|max:1024',
            ]);

            if($site_info->site_logo == 'logo.jpg' || $site_info->site_icon == 'logo.png'){
                $del_old_image = public_path('assets/img/logo/'. $site_info->site_icon);
                unlink($del_old_image);
            }

            $upl_file = $request->site_logo;
            $ext = $upl_file->getClientOriginalExtension();
            $file_name = 'logo.'.$ext;
            Image::make($upl_file)->resize(400, 100)->save(public_path('assets/img/logo/'. $file_name));

            SiteinfoTab::find($id)->update([
                'site_logo' => $file_name,
            ]);
        }
        
        SiteinfoTab::find($id)->update([
            'site_name' => $request->site_name,
            'site_email' => $request->site_email,
            'site_ph_code' => $request->site_ph_code,
            'site_phone' => $request->site_phone,
            'site_add1' => $request->site_add1,
            'site_add2' => $request->site_add2,
        ]);
        return back()->with('job_upd', 'Site Info Updated!');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
