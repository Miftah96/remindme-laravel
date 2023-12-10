<?php

namespace App\Http\Controllers\Api;

use Auth;
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
    public function index(Request $request)
    {
        try {
            $limit = $request->limit;
            $reminders = Reminder::getData($limit);
            return Response::successWithLimit($reminders, $limit);
        } catch (\Throwable $th){
            DB::rollBack();
            return  Response::internalServerError();
        }
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
        try {
            $reminder = Reminder::getDetail($id);
            
            if ($reminder->isEmpty()) {
                return Response::errNotFound();
            }

            return Response::success($reminder);
        
        } catch (\Throwable $th){
            DB::rollBack();
            return  Response::internalServerError();
        }

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
        $reminder = Reminder::where('id', $id)->first();

        if (empty($reminder)) {
            return Response::errNotFound(404);
        } else {
            $reminder->delete();

            return Response::delete($reminder);
        }
    }
}
