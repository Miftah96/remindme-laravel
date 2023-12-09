<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Reminder extends Model
{
    protected $table = 'reminders';
    protected $primaryKey = 'id';
    protected $fillable = [
        'title',
        'description',
        'remind_at',
        'event_at'
    ];

    public function scopeGetData($query)
    {
        return $query->select(DB::raw('id, title, description, remind_at, event_at'))->get();
    }

    public function scopeGetDetail($query, $id)
    {
        return $query->select(DB::raw('id, title, description, remind_at, event_at'))->where("id", $id)->get();
    }

}
