@props(['followingUser'])

<div class="flex flex-col m-4 p-4 gap-4 w-1/5 self-center h-1/2 border-r  border-gray-500">
    @foreach($followingUser as $user)
    <a href="/user-profile/{{ $user->username }}" class="flex flex-col items-center">
        <img src="{{ $user->profile_image }}" alt="{{ $user->username }}" class="w-14 h-14 rounded-full object-cover" >
    </a>
    @endforeach
</div>