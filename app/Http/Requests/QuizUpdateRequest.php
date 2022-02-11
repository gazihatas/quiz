<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuizUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        return [
            'title' => 'required|min:3|max:200',
            'description' => 'required|min:3|max:1000',
            'finished_at' => 'nullable|after:'.now()
        ];
    }

    public function attributes() {
        return [
            'title' => 'Quiz Başlığı',
            'description' => 'Quiz Açıklama',
            'finished_at' =>  'Bitiş Tarihi'
        ];
    }
}
