<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function store(Request $request)
    {
        Client::create($this->validateRequest($request));
    }

    public function update(Request $request, Client $client)
    {

        $client->update($this->validateRequest($request));
    }

    /**
     * return mixed
     */

    private function validateRequest(Request $request)
    {
        return $request->validate([
            'name' => 'required',
            'hours' => 'required|integer'
        ]);
    }
}
