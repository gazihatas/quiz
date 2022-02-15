<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{   
    protected $fillable =['question', 'answer1','answer2','answer3','answer4','correct_answer','image'];

    use HasFactory;

    public function my_answer()
    {
        return $this->hasOne('App\Models\Answer')->where('user_id',auth()->user()->id);
    } 
}
