<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSendMailRequest;
use App\Http\Requests\UpdateSendMailRequest;
use App\Models\SendMail;

class SendMailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreSendMailRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSendMailRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SendMail  $sendMail
     * @return \Illuminate\Http\Response
     */
    public function show(SendMail $sendMail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SendMail  $sendMail
     * @return \Illuminate\Http\Response
     */
    public function edit(SendMail $sendMail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSendMailRequest  $request
     * @param  \App\Models\SendMail  $sendMail
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSendMailRequest $request, SendMail $sendMail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SendMail  $sendMail
     * @return \Illuminate\Http\Response
     */
    public function destroy(SendMail $sendMail)
    {
        //
    }
}
