
<div class="flex w-full justify-center gap-4 ">
    <a href="/posts/{{ $post->id }}" class="font-bold">
        <img src="{{ asset('storage/'. $post->post_image)}}" class="max-h-[400px] aspect-square object-cover rounded border" alt=" {{$post->description}} ">
    </a>
</div>