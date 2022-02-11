<x-app-layout>
    <x-slot name="header"> Quiz Oluştur</x-slot>
        
    <div class="card">
        <div class="card-body">
            <form action="{{ route('quizzes.store')}}" method="POST">
            @csrf
                <div class="form-group">
                    <label for="title">Quiz Başlıgı</label>
                    <input type="text" id="title" name="title" class="form-control" >
                </div>
                
                <div class="form-group">
                    <label for="description">Quiz Açıklama</label>
                    <textarea id="description" name="description" class="form-control" rows="4"></textarea>
                </div>
                
                <div class="form-group">
                    <input type="checkbox" id="isFinished" @if(old('finished_at')) checked @endif >
                    <label>Bitiş Tarihi Olacak Mı?</label>
                </div>

                <div class="form-group" id="finishedInput" @if(!old('finished_at')) style="display: none;" @endif>
                    <label>Bitiş Tarihi</label>
                    <input type="datetime-local" name="finished_at" class="form-control">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success btn-sm btn-block">Quiz Oluştur</button>
                </div>
            </form>
        </div>
    </div>
    <x-slot name="js">
        <script>
            $('#isFinished').change(function() {
                if($('#isFinished').is(':checked')) {
                    $('#finishedInput').show();
                } else{
                    $('#finishedInput').hide();
                }
            })
        </script>
    </x-slot>
</x-app-layout>