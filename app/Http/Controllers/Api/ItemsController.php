<?php

namespace App\Http\Controllers\Api;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\Controller;
use App\Http\Resources\ItemResource;
use App\Http\Requests\ItemRequest;

class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return ItemResource
     */
    public function index()
    {
        return ItemResource::collection(Item::orderBy('created_at', 'asc')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validated();
        if($validated)
        {
            $item = new Item();

            $item->name = request('name');
            $item->description = request('description');
            $item->price = request('price');
            $item->image = request('image');
            $item->number_available = request('number_available');    
            $item->size = request('size');
            
        }

        if($request->hasFile('image'))
        {
            $path = Storage::putFile('public/images', $request->file('image'), 'public');

            // $path includes 'public/', and we don't want that in our URL, so we chop it off:
            $path = substr($path, 6);

            $item->image = $path;
        }

        if ($item->save()) 
        {
            return response()->json(['message' => 'Item successfully created and persisted'], Response::HTTP_CREATED);
        };

        // Care Package did not save, return 417
        return response()->json(['message' => 'Item did not save'], Response::HTTP_EXPECTATION_FAILED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        //
    }
}
