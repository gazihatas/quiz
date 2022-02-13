<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Http\Requests\QuizCreateRequest;
use App\Http\Requests\QuizUpdateRequest;

class QuizController extends Controller
{
    
    
    public function index()
    {   
        $quizzes = Quiz::withCount('questions');

        if(request()->get('title'))
        {
            $quizzes = $quizzes->where('title','LIKE',"%".request()->get('title')."%");
        }

        if(request()->get('status'))
        {
            $quizzes = $quizzes->where('status',request()->get('status'));
        }

        $quizzes = $quizzes->paginate(5);
        return view('admin.quiz.list',compact('quizzes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.quiz.create');
    }

    
    public function store(QuizCreateRequest $request)
    {
        //Post edilem tüm verileri aldık.
        //return dd($request->post());

        // Post edilen verilerin veri tababnınına kayıt işlemi gerçekleşti.
        Quiz::create($request->post());
        // İşlemler bittikten sonra qizlerin görüntülendiği yani index metoduna yönlendiriyoruz.
        return redirect()->route('quizzes.index')->withSuccess('Quiz Başarıyla Oluşturuldu');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $quiz = Quiz::withCount('questions')->find($id) ?? abort(404,'Quiz Bulunamadı');
        //dd($quiz);
        return view('admin.quiz.edit',compact('quiz'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(QuizUpdateRequest $request, $id)
    {
        $quiz = Quiz::find($id) ?? abort(404, "Quiz Bulunamadı");
        
        Quiz::find($id)->update($request->except(['_method','_token']));

        return redirect()->route('quizzes.index')->withSuccess('Quiz güncelleme işlemi başarıyla gerçekleşti.');
        //return dd($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $quiz = Quiz::find($id) ?? abort(404, 'Quiz Bulunamadı');
        $quiz->delete();
        return redirect()->route('quizzes.index')->withSuccess('Quiz silme işlemi başarıyla gerçekleşti.');
    }
}
