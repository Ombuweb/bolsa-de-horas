<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
    public function store(Request $request)
    {
        $client = Client::create($this->validateRequest($request));
        return redirect($client->path());
    }

    public function update(Request $request, Client $client)
    {
        $data = $request->except('_token');
        $data['slug'] = $data['name'];

        $validated = Validator::make($data,[
            'name' => [
                'required',
                'string',
                Rule::unique('clients')->ignore($client->id)
            ],
            'slug' => 'required|string|unique:clients',
            'hours' => 'required|integer'
        ])->validate();

        $client->update($validated);
        //dd($client->path());
        return redirect($client->path());
    }

   public function destroy(Client $client){
       $client->delete();
       return redirect('/clients');
   }
    private function validateRequest(Request $request)
    {
        $data = $request->except('_token');
        $data['slug'] = Str::slug($data['name']);
        return Validator::make($data,[
            'name' => 'required|unique:clients|string',
            'slug' => 'required|string|unique:clients',
            'hours' => 'required|integer'
        ])->validate();
        
    }
}
