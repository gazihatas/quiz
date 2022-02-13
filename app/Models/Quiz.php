<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;

class Quiz extends Model
{
    use HasFactory;
    use Sluggable;
    
    protected $fillable =['title', 'description','finished_at', 'slug'];

    protected $dates = ['finished_at'];

    public function getFinishAtAttributes($date)
    {
        return $date ? Carbon::parse($date) : null;
    }

    //bize soruları getirecek!
    public function questions() {
        //HEr quizin binlerce question ları olabilir. Sahip olduğu birden fazla parametreyi çekebilecek.
        return $this->hasMany('App\Models\Question');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'onUpdate' => true,
                'source' => 'title'
            ]
                
        ];
    }
}
