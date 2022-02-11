<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuizCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // oturum açıkmı anlamına gelir. False demek açık değil. True oturum açık demektir.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
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
            'description' => 'Quiz Açıklama'
        ];
    }
}
