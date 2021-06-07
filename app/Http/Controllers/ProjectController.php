<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $data = $request->except('_token');
        $data['slug'] = Str::slug($data['name']);

        $validted = Validator::make($data, $rules = [
            'name' => 'required|string|unique:projects|max:255',
            'slug' => 'required|string|unique:projects',
            'client_id' => 'required|integer'
        ])->validate();
        

        $project = Project::create($validted);
        return redirect('/projects/'. $project->slug );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\m  $m
     * @return \Illuminate\Http\Response
     */
    public function show(m $m)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\m  $m
     * @return \Illuminate\Http\Response
     */
    public function edit(m $m)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\m  $m
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $data = $request->except('_token');
        $data['slug'] = Str::slug($data['name']);

        $validted = Validator::make($data, $rules = [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:projects',
            'client_id' => 'required|integer'
        ])->validate();

        $project->update($validted);
        return redirect('/projects/' . $validted['slug']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\m  $m
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $clientId = $project->id;//to be replaced with client slug
        $project->delete();
        return redirect('/projects');
       
    }
}
