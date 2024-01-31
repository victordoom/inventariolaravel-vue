<?php

namespace App\Http\Controllers;

use App\Models\Disc;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia; 

class DiscController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $discs = Disc::all();
        $user = User::find(auth()->user()->id);
        $userpermission = $user->getPermissionsViaRoles();
        return Inertia::render('Discs/Index', ['discs' => $discs, 'userpermission' => $userpermission]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Discs/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:150',
            'album' => 'required|min:5',
            'artist' => 'required|min:5',
            'gender' => 'required|min:5',
            'year' => 'required|min:4',

        ]);

        $discs = new Disc($request->input());
        $discs->save();
        return redirect('discs');
    }

    /**
     * Display the specified resource.
     */
    public function show(Disc $disc)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Disc $disc)
    {
        return Inertia::render('Discs/Edit', ['disc' => $disc]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Disc $disc)
    {
        $request->validate([
            'name' => 'required|max:150',
            'album' => 'required|max:255',
            'artist' => 'required|max:255',
            'gender' => 'required|min:5',
            'year' => 'required|min:4',

        ]);

        $disc->update($request->all());
        return redirect('discs');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Disc $disc)
    {
        $disc->delete();
        return redirect('discs');
    }
}
