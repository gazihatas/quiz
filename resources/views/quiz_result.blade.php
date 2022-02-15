<x-app-layout>
    <x-slot name="header"> {{ $quiz->title }} Sonucu </x-slot>

<div class="div-card">
    <div class="card-body">
        
        {{-- Bilgilendirme Kısmı --}}
        <h3>Puanın : <strong> {{$quiz->my_result->point}} </strong></h3>
        <div class="alert alert-light">
            <i class="fa fa-square"></i> İşaretlediğin Şık.
            <br>
            <i class="fa fa-check text-success"></i> Doğru Cevap
            <br>
            <i class="fa fa-times text-danger"></i> Yanlış Cevap
        </div>

           
                    @foreach ($quiz->questions as $question)
                        
                        @if($question->correct_answer == $question->my_answer->answer)
                            <i class="fa fa-check text-success"></i>
                        @else
                            <i class="fa fa-times text-danger"></i>
                        @endif    

                        <strong>#{{$loop->iteration}} </strong>      
                        
                        {{$question->question}}
                        @if($question->image)
                            <img src="{{asset($question->image)}}" alt="img-responsive" width="30%" >
                        @endif
                        
                        <br>
                        <small>Bu soruya <strong>% {{$question->true_percent}}</strong> oranında doğru cevap verildi.</small>

                        {{-- CEVAP 1 --}}
                        <div class="form-check mt-2">
                            @if('answer1' == $question->correct_answer)
                                <i class="fa fa-check text-success"></i>
                            @elseif('answer1' == $question->my_answer->answer)
                                <i class="fa fa-square"></i>
                            @endif

                            <label class="form-check-label" for="quiz{{$question->id}}1">
                                {{$question->answer1}}
                            </label>
                        </div>

                        {{-- CEVAP 2 --}}
                        <div class="form-check">
                            @if('answer2' == $question->correct_answer)
                                <i class="fa fa-check text-success"></i>
                            @elseif('answer2' == $question->my_answer->answer)
                                <i class="fa fa-square"></i>
                            @endif

                            <label class="form-check-label" for="quiz{{$question->id}}2">
                                {{$question->answer2}}
                            </label>
                        </div>

                        {{-- CEVAP 3 --}}
                        <div class="form-check">
                            @if('answer3' == $question->correct_answer)
                                <i class="fa fa-check text-success"></i>
                            @elseif('answer3' == $question->my_answer->answer)
                            <i class="fa fa-square"></i>    
                            @endif

                            <label class="form-check-label" for="quiz{{$question->id}}3">
                                {{$question->answer3}}
                            </label>
                        </div>

                        {{-- CEVAP 4 --}}
                        <div class="form-check">
                            @if('answer4' == $question->correct_answer)
                                <i class="fa fa-check text-success"></i>
                            @elseif('answer4' == $question->my_answer->answer)
                            <i class="fa fa-square"></i>    
                            @endif

                            <label class="form-check-label" for="quiz{{$question->id}}4">
                                {{$question->answer4}}
                            </label>
                        </div>

                        {{-- eğer sonuncu değilse if geçerli olur --}}
                        @if(!$loop->last) 
                            <hr>
                        @endif
                        
                    @endforeach

          
           

            
    </div>
</div>




</x-app-layout>
