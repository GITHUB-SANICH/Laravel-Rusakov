<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
	public function __construct()
	{
		$this->authorizeResource(Address::class, 'address');
	}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
		/*
		if (!$request->user() || $request->user()->cannot('viewAny', Address::class)) {
			abort(403);
		}
		*/
		return view('addresses.index', ['addresses' => Address::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
			//$this->authorize('create', Address::class);
        return view('addresses.form', ['action' => 'create']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAddressRequest $request)
    {
		//$this->authorize('store', Address::class);
		$validated = $request->safe();
		$address = new Address();
		$address->address = $validated->address;
		$address->save();
		return redirect()->route('addresses.index');
	 }	

    /**
     * Display the specified resource.
     */
    public function show(Address $address)
    {
		//$this->authorize('view', $address);
		return view('addresses.show', ['address' => $address]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Address $address)
    {
		//$this->authorize('update', $address);  
		return view('addresses.form', ['action' => 'edit', 'address' => $address]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAddressRequest $request, Address $address)
    {
		//$this->authorize('update', $address);
		$validated = $request->safe();
		$address->address = $validated->address;
		$address->save();
		return redirect()->route('addresses.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $address)
    {
		//$this->authorize('delete', $address);
		$address->delete();
		return redirect()->route('addresses.index');
    }
}
