<?php
 use App\models\Section;

if (!function_exists('sections')) {
    function sections()
    {
        $sections = Section::all();
        $sections_arr= [];
        foreach ($sections as $section) {
            $section_arr = [];
            $section_arr['text'] = $section->name;
            $section_arr['li_attr'] = '';
            $section_arr['a_attr'] = '';
            $section_arr['icon'] = '';
            $section_arr['children'] = [];
            $section_arr['parent'] = $section->parent_id === null ? '#' : $section->parent_id;
            $section_arr['id'] = $section->id;
            array_push($sections_arr, $section_arr);
        }
        return $sections_arr;
    }
}
