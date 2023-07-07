<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('addresses.index', ['addresses' => Address::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('addresses.form', ['action' => 'create']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAddressRequest $request)
    {
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
		return view('addresses.show', ['address' => $address]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Address $address)
    {
		return view('addresses.form', ['action' => 'edit', 'address' => $address]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAddressRequest $request, Address $address)
    {
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
		$address->delete();
		return redirect()->route('addresses.index');
    }
}
