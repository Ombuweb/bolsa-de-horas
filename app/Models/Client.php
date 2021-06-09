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
    public function formattedTotalTimeSpent(){
        $seconds = $this->totalTimeSpent();
        $hours = floor($seconds / 3600);
        $mins = floor($seconds / 60 % 60);
        $secs = floor($seconds % 60);
            return "$hours:$mins:$secs";
    }
}
