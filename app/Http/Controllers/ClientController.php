<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateClientRequest;
use App\Http\Requests\EditClientRequest;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

use function Laravel\Prompts\error;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientsPaginator = Client::paginate(20);

        return view('Client.index',['clientsPaginator' => $clientsPaginator]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Client.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateClientRequest $request)
    {
        Client::create($request->validated());
        return redirect(route('clients.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        return view('Client.show',['client' => $client]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        return view('Client.edit',['client' => $client]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditClientRequest $request, Client $client)
    {
        $client->update($request->validated());
        return redirect(route('client.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        abort_if(Gate::denies('delete'),Response::HTTP_FORBIDDEN,'403 Forbidden',);
        $client->delete();
        redirect(route('clients.index'));
    }
}
