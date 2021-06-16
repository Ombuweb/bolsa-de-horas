<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug', 'hours'];

    public function path()
    {
        return '/clients/' . $this->slug;
    }
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function totalTimeSpent()
    {
        return $this->projects->reduce(function ($carry, $d) {
            return $carry + $d->totalTimeSpentSoFar();
        });
    }
    public function formattedTotalTimeSpent($seconds){
        
        $hours = floor($seconds / 3600);
        $mins = floor($seconds / 60 % 60);
        $secs = floor($seconds % 60);
        $timePadded = str_pad($hours, 2,'0' ,STR_PAD_LEFT). ':' .str_pad($mins, 2, '0',STR_PAD_LEFT)  . ':' . str_pad($secs, 2,'0',STR_PAD_LEFT);

            return $timePadded;
    }
    public function timeRemaining(){
        return ($this->hours * 3600) - $this->totalTimeSpent();
    }
   
}
