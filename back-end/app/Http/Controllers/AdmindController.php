<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdmindController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dashboard()
    {
        return view('admin.dashboard'); 
    }
    // public function AjouterMoniteur()
    // {
    //     return view('admin.AjouterMoniteur'); 
    // }

    public function gestionMoniteur()
    {
        return view('admin.gestionMoniteur'); 
    }

    public function gestionCandidats()
    {
        return view('admin.gestionCandidats'); 
    }


    // public function  AjouterQuiz() {
    //     return view('admin.AjouterQuiz'); 

    // }
    
    public function  AjouterQuestions() {
        return view('admin.AjouterQuestions'); 

    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
