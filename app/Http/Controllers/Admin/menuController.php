<?php

namespace App\Http\Controllers\Admin;

use App\menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class menuController extends Controller
{
    public function index(menu $menu)
    {
        $menus=$menu->orderBy('position')->get();
        return view('Admin.menus.all' , compact('menus'));
    }

    public function create()
    {

        return view('Admin.menus.create');
    }

    public function store(Request $request, menu $menu)
    {
        $menu->create([
           'title' => $request->title ,
            'position' => $request->position,
            'url' => $request->url,
        ]);
        return redirect()->route('menus.index');
    }
    public function edit(menu $menu)
    {
        return view('Admin.menus.edit' ,compact('menu'));
    }

    public function update(menu $menu , Request $request)
    {

        $menu->update([
            'title' => $request->title ,
            'position' => $request->position,
            'url' => $request->url,
        ]);
        return redirect()->route('menus.index');
    }


    public function destroy(menu $menu , Request $request)
    {

        $menu->delete();
        return back();
    }
}
