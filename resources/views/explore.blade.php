<x-app-layout>
   @if($posts->count() < 1)
        <div class="flex justify-center items-center">
            <div class="text-gray-900 dark:text-gray-100 text-2xl">
                <p>There are no posts to show</p>
                <p>Check out other posts <a href="/community" class="text-blue-500 underline"> here </a></p>

            </div>
        </div>
    @else
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-gray-200 sm:rounded-lg flex">
                    <x-following-users-sidebar :followingUser="$followingUser" />
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12 bg-gray-800 mt-4 grid lg:grid-cols-3 sm:grid-cols-1 rounded-xl ">
                    @foreach($posts as $post)
                        <x-post-image :post="$post" />
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>
