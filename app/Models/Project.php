<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'client_id'];

    protected $touches = ['client'];
    protected $with = ['tasks'];

    public function tasks()
    {

        return $this->hasMany(Task::class);
    }
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function timeSpentSoFar()
    {
        //get all projects tasks and sum up the time
        //1. add seconds and 

        $seconds = $this->totalTimeSpentSoFar();
        $hours = floor($seconds / 3600);
        $mins = floor($seconds / 60 % 60);
        $secs = floor($seconds % 60);
        $timePadded = str_pad($hours, 2,'0' ,STR_PAD_LEFT). ':' .str_pad($mins, 2, '0',STR_PAD_LEFT)  . ':' . str_pad($secs, 2,'0',STR_PAD_LEFT);
        return $timePadded;
    }

    public function totalTimeSpentSoFar(){
        return $this->tasks->reduce(function($carry,$d){
            return $carry + $d->time_spent_on_secs;
        });
    }
}
