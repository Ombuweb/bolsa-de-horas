<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $this->authorize('view-all-projects',Project::class);
       return view('projects', ['data' => Project::all()]);
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
        $this->authorize('create', Project::class);
        $data = $request->except('_token');
        $data['slug'] = Str::slug($data['name']);

        $validted = Validator::make($data, $rules = [
            'name' => 'required|string|unique:projects|max:255',
            'slug' => 'required|string|unique:projects',
            'client_id' => 'required|integer'
        ])->validate();


        $project = Project::create($validted);
      
        return redirect('/projects/' . $project->slug);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\m  $m
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        
        $this->authorize('view', $project);

        return view('project', ['data' => $project]);
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
    {        $this->authorize('update', Project::class);

        $data = $request->except('_token');
        $data['slug'] = Str::slug($data['name']);

        $validted = Validator::make($data, $rules = [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('projects')->ignore($project->id)
            ],
            'slug' =>[
                'required',
                'string',
                'max:255',
                Rule::unique('projects')->ignore($project->id)
            ],
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
        $this->authorize('delete', Project::class);
        $clientId = $project->id; //to be replaced with client slug
        $project->delete();
        return redirect('/projects');
    }
}
