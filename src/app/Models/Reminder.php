<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

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

    public function scopeGetData($query, $limit)
    {
        return $query->select(DB::raw('id, title, description, remind_at, event_at'))
            ->when($limit, function ($query, $limit) {
                return $query->limit($limit);
            })->get();
    }

    public function scopeGetDetail($query, $id)
    {
        return $query->select(DB::raw('id, title, description, remind_at, event_at'))->where("id", $id)->get();
    }

}
