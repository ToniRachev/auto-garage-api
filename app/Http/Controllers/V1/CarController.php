<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CarResource;
use App\Models\Car;
use App\Http\Requests\V1\Car\StoreCarRequest;
use App\Http\Requests\V1\Car\UpdateCarRequest;
use App\Responses\V1\ApiResponse;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ApiResponse::paginated(Car::paginate(), CarResource::class);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCarRequest $request)
    {

        return ApiResponse::created(
            'Car was successfully created.',
            new CarResource(Car::create($request->validated()))
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {
        return ApiResponse::ok(data: new CarResource($car->load(['client', 'orders'])));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCarRequest $request, Car $car)
    {
        $car->fill($request->validated());

        if ($car->isDirty()) {
            $car->save();
        }

        return ApiResponse::ok(data: new CarResource($car));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        $car->delete();
        return ApiResponse::noContent();
    }
}
