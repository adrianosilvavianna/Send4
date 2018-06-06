<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\MessageRequest;
use App\Http\Resources\MessageResource;
use App\Models\Contact;
use App\Models\Message;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class MessageController extends Controller
{

    /**
     * List messages from contact
     *
     * @param Contact $contact
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Contact $contact)
    {
        return MessageResource::collection($contact->Messages);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Contact $contact
     * @param MessageRequest $request
     * @return MessageRequest
     */
    public function store(MessageRequest $request, Contact $contact)
    {
        $message = $contact->Messages()->create($request->input());
        return new MessageResource($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        return new MessageResource($message);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MessageRequest $request, Contact $contact, Message $message)
    {
        if($contact->authorize($message)){
            $message = $message->update($request->input());
            return response()->json($message, 200);
        }
        return response()->json(['message' => 'Este contato nao tem permissao para alterar essa menssagem'], 401);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Message $message
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Contact $contact, Message $message)
    {
        if($contact->authorize($message)) {
            return response()->json($message->delete(), 200);
        }
        return response()->json(['message' => 'Este contato não tem permissão para auterar essa menssagem'], 401);
    }
}
