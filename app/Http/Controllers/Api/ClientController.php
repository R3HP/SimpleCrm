<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateClientRequest;
use App\Http\Requests\EditClientRequest;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use Illuminate\Http\Request;

use function Laravel\Prompts\error;

class ClientController extends Controller
{
    public function __construct()
    {
        request()->headers->add(['Accept','application/json']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ClientResource::collection(Client::paginate(20));
        // $clients = Client::all();
        // return response()->json($clients);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateClientRequest $request)
    {
        
        $client =  Client::create($request->validated());

        if ($client) {
            return response()->json([
                'message' => 'Client Created Successfully',
                new ClientResource($client)
            ]);
        }else{
            return response()->json([
                'message' => 'Could not Create Client',
            ],400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        return new ClientResource($client);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditClientRequest $request, Client $client)
    {
        $success = $client->update($request->validated());

        if ($success) {
            return response()->json([
                'message' => 'Client Updated Successfully',
                new ClientResource($client->refresh())
            ]);
        }else{
            return response()->json([
                'message' => 'Could not Create Client',
            ],400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $success = $client->delete();

        if ($success) {
            return response()->json([
                'message' => 'Client Deleted Successfully',
            ]);
        }else{
            return response()->json([
                'message' => 'Could not Create Client',
            ],400);
        }
    }
}
