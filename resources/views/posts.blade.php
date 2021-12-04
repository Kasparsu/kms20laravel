@extends('layout')
@section('title', 'Posts')
@section('content')
    <h1>Posts</h1>
    <a href="{{$posts->previousPageUrl()}}" class="btn btn-primary {{ $posts->previousPageUrl() ? '' : 'disabled' }}">prev</a>

    @if($posts->nextPageUrl())
        <a href="{{$posts->nextPageUrl()}}" class="btn btn-primary">next</a>
    @else
        <a class="btn btn-primary disabled">next</a>
    @endif

    {{$posts->links()}}
    <div class="row row-cols-4">
        @foreach($posts as $post)
            <div class="col mb-3">
                <div class="card h-100">
                    @if($post->images->count() > 1)
                        @include('partials.carousel', ['id' => $post->id, 'images' => $post->images])
                    @elseif($post->images->count() == 1)
                        <img src="{{$post->images->first()->path}}" class="card-img-top" alt="...">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{$post->title}}</h5>
                        <p class="card-text">{{$post->snippet}}</p>
                        <p class="text-muted">{{$post->user->name}}</p>
                        <p class="text-muted datetime">{{$post->created_at->toISOString()}}</p>
                        <p class="text-muted">{{$post->created_at->diffForHumans()}}</p>
                        <p class="text-muted"><b>Comments:</b>{{$post->comments()->count()}}</p>
                        <p class="text-muted">
                            @foreach($post->tags as $tag)
                                <a href="{{route('tag', ['tag'=>$tag])}}">{{$tag->name}}</a>
                            @endforeach
                        </p>
                        <p class="text-muted">
                               <b>Likes:</b> {{$post->likes()->count()}}
                                <a href="{{route('like', ['post'=>$post])}}">
                                    @if($post->authHasLiked)
                                        Unlike
                                    @else
                                        Like
                                    @endif
                                </a>
                        </p>
                        <a href="{{route('post', ['post'=>$post])}}" class="btn btn-primary">Read more</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

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
            let currentTime = DateTime.fromISO(el.innerHTML, { zone: "UTC" }).setZone(DateTime.local().zoneName);
            el.innerHTML = currentTime;
        });
    </script>
@endpush


