<x-app-layout>
    
    <div class="flex">

        <x-following-users-sidebar :followingUser="$followingUser" />
        <x-user-profile :user="$user" />
        
    </div>

</x-app-layout>