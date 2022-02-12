<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;
    
    protected $fillable =['title', 'description','finished_at'];

    //bize soruları getirecek!
    public function questions() {
        //HEr quizin binlerce question ları olabilir. Sahip olduğu birden fazla parametreyi çekebilecek.
        return $this->hasMany('App\Models\Question');
    }
}
