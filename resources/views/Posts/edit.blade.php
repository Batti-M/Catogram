<x-app-layout>
 
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('posts.update', $post->id) }}">
                        @csrf
                        @method('PATCH')
                        <label for="description">Description</label>
                        <input type="text" name="description" id="description" class="block mt-1 w-full text-gray-800"  autocomplete="description" value="{{ $post->description }}"/>
                        <label for="content"> Content</label>
                        <textarea name="content" id="content" class="block mt-1 w-full text-gray-800" required autofocus autocomplete="content" value="{{ $post->content }}"></textarea>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mt-4 rounded">Create Post</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>