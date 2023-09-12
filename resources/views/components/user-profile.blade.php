<div class="container w-4/5 mx-auto px-4 text-gray-200 flex flex-col">
    <div class="flex items-center mt-4 justify-center gap-12">
        <img src="{{ $user->profile_image }}" alt="{{ $user->username }}" class="w-24 h-24 rounded-full object-cover" >
        <a type="button" href="/profile" class="text-gray-100 px-5 py-2 rounded mx-8 flex flex-col border border-gray-200 items-center"
        style="display: {{ auth()->user()->id === $user->id ? 'block' : 'none' }};">
            Profil bearbeiten
        </a>
        <div class="ml-4">
            <h2 class="text-2xl font-semibold">{{ $user->username }}</h2>
            <div class="flex mt-2 space-x-4">
                <span class="text-sm text-gray-600"><strong>Posts:</strong> {{ count($user->posts )}}</span>
                <span class="text-sm text-gray-600"><strong>Followers:</strong> {{ count($user->followers) }}</span>
                <span class="text-sm text-gray-600"><strong>Following:</strong> {{ count($user->following)}}</span>
            </div>
        </div>
    </div>

    <hr class="my-4">

    <div class="grid grid-cols-3 gap-4">
        @foreach($user->posts as $post)
        <x-post-image :post="$post" />
        @endforeach
    </div>
    
</div>