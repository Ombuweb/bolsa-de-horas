<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function store(Request $request)
    {
        $client = Client::create($this->validateRequest($request));
        return redirect($client->path());
    }

    public function update(Request $request, Client $client)
    {

        $client->update($this->validateRequest($request));
        return redirect($client->path());
    }

   public function destroy(Client $client){
       $client->delete();
       return redirect('/clients');
   }
    private function validateRequest(Request $request)
    {
        return $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:clients',
            'hours' => 'required|integer'
        ]);
    }
}
