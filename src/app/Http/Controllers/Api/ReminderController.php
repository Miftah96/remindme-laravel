<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reminder;
use App\Helpers\Response;
use Illuminate\Support\Facades\DB;

class ReminderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reminders = Reminder::getData();
        return Response::success($reminders);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        try {
            $reminder = new Reminder();
            $reminder->fill($data);
            $reminder->save();


            return Response::custome($reminder);
        }

        catch (\Throwable $th){
            DB::rollBack();
            return  Response::internalServerError();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $reminder = Reminder::getDetail($id);
        return Response::success($reminder);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $reminder)
    {
        DB::beginTransaction();

        try{
            $reminder = Reminder::findOrFail($reminder);
            $reminder->fill($request->all());
            $reminder->update();
            DB::commit();

            return Response::custome($reminder);
        } catch (\Throwable $th){
            DB::rollBack();

            return Response::internalServerError();
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $reminder = Reminder::findOrFail($id);

        $reminder->delete();

        return Response::delete($reminder);
    }
}
