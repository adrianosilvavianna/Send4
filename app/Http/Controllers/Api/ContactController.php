<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ContactRequest;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    private $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ContactResource::collection($this->contact->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContactRequest $request)
    {
        try{
            $contact = $this->contact->create($request->input());
            return new ContactResource($contact);
        }catch (\Exception $e){
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * @param $id
     * @return ContactResource
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contact = $this->contact->findOrFail($id);
        return new ContactResource($contact);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ContactRequest $request
     * @param Contact $contact
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ContactRequest $request, Contact $contact)
    {
        $contact = $contact->update($request->input());
        return response()->json($contact, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Contact $contact
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Contact $contact)
    {
        return response()->json($contact->delete(), 200);
    }
}
