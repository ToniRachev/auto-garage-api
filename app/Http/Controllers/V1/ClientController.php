<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Client\StoreClientRequest;
use App\Http\Requests\V1\Client\UpdateClientRequest;
use App\Http\Resources\V1\ClientResource;
use App\Models\Client;
use App\Responses\V1\ApiResponse;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::latest()->paginate();
        return ApiResponse::paginated($clients, ClientResource::class);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClientRequest $request)
    {
        $client = Client::create($request->validated());
        return ApiResponse::created(
            message: 'Client was created successfully',
            data: new ClientResource($client)
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        return ApiResponse::ok(data: new ClientResource($client));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientRequest $request, Client $client)
    {
        $client->fill($request->validated());

        if ($client->isDirty()) {
            $client->save();
        }

        return ApiResponse::ok(data: new ClientResource($client));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();
        return ApiResponse::noContent();
    }
}
