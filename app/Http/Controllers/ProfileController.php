<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    public function addFriend($id)
    {
        $user = \Auth::user();
        $external = \App\User::find($id);
        $response = $user->befriend($external);
        if($response == true) {
            return \Redirect::back()->with('success', 'Se ha agregado satisfactoariamente como amigo, Hay que esperar a que te acepten.');
        } 
        return \Redirect::back()->with('error', 'Ya se mando invitación previamente.');
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function acceptFriendship($id)
    {
        $user = \App\User::find($id);
        $response = \Auth::user()->acceptFriendRequest($user);
        if($response == true) {
            return \Redirect::back()->with('success', 'Has aceptado la solicitud de amistad.');
        } 
        return \Redirect::back()->with('error', 'Un error sucedio.');

    }


    public function denyFriendship($id)
    {
        $user = \App\User::find($id);
        $response = \Auth::user()->denyFriendRequest($user);
        if($response == true) {
            return \Redirect::back()->with('success', 'Has aceptado la solicitud de amistad.');
        } 
        return \Redirect::back()->with('error', 'Un error sucedio.');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
