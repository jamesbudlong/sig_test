<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GreetingCard;

class GreetingCardsController extends BaseController
{
    protected $greetingCard = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(GreetingCard $greetingCard)
    {
        $this->middleware('auth:api');
        $this->greetingCard = $greetingCard;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $greetingCards = $this->greetingCard->latest()->paginate(10);

        // return $this->sendResponse($categories, 'Category list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $logged_in_user = auth()->user()->id;

        $greeting_card = GreetingCard::create([
            'canvas_data' => $request['canvas_data'],
            'sender' => $logged_in_user,
            'recipient' => $request['recipient'],
        ]);

        return $this->sendResponse($greeting_card, 'Greeting Card sent!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Get all sent greeting cards of the user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sentGreetingCard()
    {
        $logged_in_user = auth()->user()->id;

        $greetingCards = $this->greetingCard->where('sender', $logged_in_user)->with('recipient:id,name')->paginate(10);

        return $this->sendResponse($greetingCards, 'Greeting Cards list');
    }

    /**
     * Get all received greeting cards of the user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function receivedGreetingCard()
    {
        $logged_in_user = auth()->user()->id;

        $greetingCards = $this->greetingCard->where('recipient', $logged_in_user)->with('sender:id,name')->paginate(10);

        return $this->sendResponse($greetingCards, 'Greeting Cards list');
    }

}
