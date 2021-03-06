<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
    public function index()
    {
        $this->authorize('view-all-clients', Client::class);
        return view('admin.clients.index', ['clients' => Client::all()]);
    }
    public function create()
    {
        return view('admin.clients.create');
    }
    public function store(Request $request)
    {
        $this->authorize('create', Client::class);
        $client = Client::create($this->validateRequest($request));
        return redirect($client->path());
    }
    public function edit(Client $client)
    {
        return view('admin.clients.update', ['client' => $client]);
    }
    public function update(Request $request, Client $client)
    {
        $this->authorize('update', $client);
        $data = $request->except('_token');
        $data['slug'] = Str::slug( $data['name']);

        $validated = Validator::make($data, [
            'name' => [
                'required',
                'string',
                Rule::unique('clients')->ignore($client->id)
            ],
            'slug' => [
                'required',
                'string',
                Rule::unique('clients')->ignore($client->id)
            ],
            'hours' => 'required|integer'
        ])->validate();

        $client->update($validated);
        return redirect($client->path());
    }
    public function show(Client $client)
    {

        $this->authorize('view',  $client);

        return view('admin.clients.show', ['projects' => $client->projects, 'client' => $client]);
    }
    public function destroy(Client $client)
    {
        $this->authorize('delete', Client::class);
        $client->delete();
        return redirect('/clients');
    }
    private function validateRequest(Request $request)
    {
        $data = $request->except('_token');
        $data['slug'] = Str::slug($data['name']);
        return Validator::make($data, [
            'name' => 'required|unique:clients|string',
            'slug' => 'required|string|unique:clients',
            'hours' => 'required|integer'
        ])->validate();
    }
}
