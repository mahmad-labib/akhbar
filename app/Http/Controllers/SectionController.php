<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\models\Section;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = Section::all();
        $sections_list = sections();
        return view('layouts/admin-temp/pages/sections', ['sectionsTree' => json_encode($sections_list)])->with('sections',$sections);
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
        $name = $request->name;
        $parentId = $request->parent_id;
        $chkName = Section::where('name', $name)->first();
        if ($chkName !== null) {
            return redirect('/sections')->withErrors(['section already exist']);
        }
        $section = new Section;
        $section->name = $name;
        $section->parent_id = $parentId;
        $section->save();

        return redirect('/sections')->with('status', 'section saving success');
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
        $section = Section::where('id', $id)->first();
        $section_parent = Section::where('id', $section->parent_id)->first();
        $section->parent = $section_parent;
        $sections_list = sections();
        return view('layouts/admin-temp/pages/section_edit',  ['sectionsTree' => json_encode($sections_list)])->with('section', $section);
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
        $section = Section::find($id);
        $section->name = $request->name;
        $section->parent_id = $request->parent_id;
        $section->save();
        return redirect('/sections')->with('status', 'section saving success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $section_parent = Section::select('parent_id')->where('id', $id)->get();
        foreach ($section_parent as $section) {
            dd($section->parent_id);
        }
        
        $children = Section::where('parent_id', $id)->get();
        foreach ($children as $child) {
            $child->parent_id = $section_parent->parent_id;
            $child->save();
        }
        $section_delete = Section::find($id)->forceDelete();
        return redirect('/sections')->with('status', 'section delete success');
    }
}
