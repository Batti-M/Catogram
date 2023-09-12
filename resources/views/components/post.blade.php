@props(['post'])
@php
    $user = auth()->user();
    $isLiked = $post->likes->contains('user_id', $user ? $user->id : null);
@endphp

<div class="flex space-x-4 ">
    <img src="{{ asset('storage/'. $post->post_image)}}" class="w-1/3 max-h-[400px] aspect-square object-cover rounded" alt=" {{$post->description}} ">
    <div class="flex flex-col w-full" 
        x-data="{open: false, like: {{ $isLiked ? 'true' : 'false' }}, comments_open: true, follow: {{ $user->following->contains($post->author->id) ? 'true' : 'false' }} }">
        <div class="flex justify-between">
            <div class="flex flex-col">
                <a href="/user-profile/{{ $post->author->username }}" 
                    class="underline hover:text-blue-500">{{$post->author->username}}</a> 
                <small>posted {{$post->created_at->diffForHumans()}} on {{ date('d-m-Y', strtotime($post->created_at)) }}</small>
            </div>
            @if($post->author->id === $user->id)
                <div class="flex">
                    <a type="button" href="/posts/{{$post->id}}/edit" class="bg-blue-500 px-4 py-2 rounded uppercase m-1"> Edit </a>
                    <form method="POST" action="{{ route('posts.destroy', $post->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 px-4 py-2 rounded uppercase mt-1"> Delete </button>
                    </form>
                </div>
            @endif
        </div>
        <p class="my-12 p-2 rounded-xl bg-gray-900">{{ nl2br($post->content) }}</p>
        @if($post->author->id !== $user->id)
        <div class="flex justify-around gap-4 self-end" >
            <form method="POST" action="/toggleLike/{{$post->id}}" 
                class="flex justify-around gap-4 self-end" >
                @csrf
                <button type="submit" class="flex  justify-around gap-4 self-end m-0 items-center" >
                
                    <i class="fa-solid fa-heart text-3xl hover:cursor-pointer" :class="like ? 'text-red-500' : 'text-white' " >    <small class="mt-0"> {{ count($post->likes) > 0 ? count($post->likes->toArray()) : 0 }}</small> </i>
                </button>
            </form>
            
            <button @click="open = !open"><i class="fa-solid fa-comment-dots text-3xl hover:cursor-pointer" > </i></button>
            <button id="followButton" @click="toggleFollow('{{ $user->id }}' , {{ $post->author }})" class="bg-blue-400 px-4 py-2 rounded hover:bg-blue-500" x-text=" follow ? 'Unfollow' : 'Follow' ">
               
            </button>
        </div>
        @else 
        <div class="self-end">
            <button @click="open = !open"><i class="fa-solid fa-comment-dots text-3xl hover:cursor-pointer" > </i></button>
        </div> 
        @endif
        <button @click="comments_open = !comments_open" x-text="comments_open ? 'Hide comments' : 'Show comments' ">  </button>
        <section x-show="open" x-transition.duration.500ms class="col-span-8 col-start-5 my-5 flex justify-end">
            @auth
                <form method="POST" action="/posts/{{$post->id}}/comments" class="border border-gray-200 p-6 rounded-xl w-3/4 ">
                    @csrf

                    <header class="flex items-center">
                        <img src="{{ $post->author->profile_image }}" alt="{{ $post->author->username }}" width="40" height="40" class="w-24 h-24 rounded-full object-cover">
                        <p class="ml-4">{{ $post->author->name }}</p>
                    </header>
                    <div class="mt-6 ">
                        <textarea name="content" 
                        class="w-full focus:ring text-gray-800 " 
                        rows="3" 
                        placeholder="Leave a comment!" 
                        required>
                        </textarea>
                        @error('content')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex justify-end border-t border-gray-300 ">
                        <button class="mt-2 py-2 px-6 bg-gray-500 rounded-xl text-white uppercase" type="submit"> send </button>
                    </div>
                </form>
                
            @endauth
        </section>
        <div class="flex flex-col justify-end w-3/4 self-end" x-show="comments_open"  x-transition.duration.300ms >
            @foreach($post->comments as $comment)
                <div class="flex flex-col m-2 p-4 rounded-lg justify-end items-end bg-gray-900">
                    <p class="bg-gray-600 p-3 mb-2 rounded-xl"> {!! nl2br($comment->content) !!} </p>
                    <div class="flex items-center">
                        <img src="{{ $comment->author->profile_image}}" alt="" width="30" height="30" class="w-12 h-12 rounded-full object-cover mr-4">
                        <a href="/user-profile/{{$comment->author->username}}" class="underline hover:text-blue-500 mr-12">{{$comment->author->username}}</a>
                        <time class="text-xs "> {{$comment->created_at->diffForHumans()}} </time>
                    </div>
                </div>
            @endforeach
        </div>
         {{-- show flash message --}}
        @if(session()->has('success'))
            <div class="fixed bottom-0 right-0 bg-gray-200 text-white p-4 rounded-xl mr-4 mb-4">
                <p>{{ session('success') }}</p>
            </div>
        @endif
    </div>
</div>

<script>

    function toggleLike(event) {
        this.like = !this.like
    }
        
    function toggleFollow(userId,author) {
        axios.post('/toggle-follow', {
            user_id: userId,
            author: author
        })
        .then(response => {
            this.follow = !this.follow
            let followButton = document.getElementById('followButton')
            followButton.innerText = this.follow ? 'Unfollow' : 'Follow'
        })
        .catch(error => {
            console.log(error);
        });
    }
</script>