<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = ['project_id','time_spent_on_secs','description'];

    protected $touches = ['project'];

    public function project(){
        return $this->belongsTo(Project::class);
    }
    private function getTimeSpentOnSecs(){
        return $this->time_spent_on_secs;
    }
    public function timeSpentOnTask(){
        $seconds = $this->getTimeSpentOnSecs();
        $hours = floor($seconds / 3600);
        $mins = floor($seconds / 60 % 60);
        $secs = floor($seconds % 60);
        $timePadded = str_pad($hours, 2,'0' ,STR_PAD_LEFT). ':' .str_pad($mins, 2, '0',STR_PAD_LEFT)  . ':' . str_pad($secs, 2,'0',STR_PAD_LEFT);
        return $timePadded;
    }
    
}
