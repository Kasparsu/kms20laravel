@extends('layout')
@section('title', 'Posts')
@section('content')

    <div class="card h-100">
        @if($post->images->count() > 1)
            @include('partials.carousel', ['id' => $post->id, 'images' => $post->images])
        @elseif($post->images->count() == 1)
            <img src="{{$post->images->first()->path}}" class="card-img-top" alt="...">
        @endif
        <div class="card-body">
            <h5 class="card-title">{{$post->title}}</h5>
            <p class="card-text">{!! $post->displayBody !!}</p>
            <p class="text-muted">{{$post->user->name}}</p>
            <p class="text-muted datetime">{{$post->created_at->toISOString()}}</p>
            <p class="text-muted">{{$post->created_at->diffForHumans()}}</p>

        </div>
    </div>

    <div class="card h-100 my-3">

        <div class="card-body">
            <form action="{{route('comment', ['post' => $post])}}" method="POST">
                @csrf
                <textarea name="body" class="form-control my-3" placeholder="Comment goes here..."></textarea>
                <input type="submit" class="btn btn-primary mb-3" value="Comment">
            </form>

        </div>
    </div>

    @foreach($post->comments()->latest()->get() as $comment)
        <div class="card h-100 my-3">

            <div class="card-body">

                <p class="card-text">{{$comment->body}}</p>
                <p class="text-muted">{{$comment->user->name}}</p>
                <p class="text-muted">{{$comment->created_at->diffForHumans()}}</p>
                <p class="text-muted"><b>Likes:</b>{{$comment->likes()->count()}}</p>
            </div>
        </div>
    @endforeach
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/luxon@2.1.1/build/global/luxon.min.js"></script>
    <script>
        let DateTime = luxon.DateTime;
        let datesEls = document.querySelectorAll('.datetime');
        // datesEls.forEach(function (el) {
        //
        // });
        datesEls.forEach(el => {
            let currentTime = DateTime.fromISO(el.innerHTML, {zone: "UTC"}).setZone(DateTime.local().zoneName);
            el.innerHTML = currentTime;
        });
    </script>
@endpush


