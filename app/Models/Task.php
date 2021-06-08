<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = ['project_id','time_spent_on_hours','time_spent_on_minutes','time_spent_on_secs','description'];
    
}
