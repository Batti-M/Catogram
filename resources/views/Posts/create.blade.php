<x-app-layout>
 
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data" >
                        @csrf
                        <img src="" id="preview" class="w-1/2 h-1/2 mx-auto" style="display: none; width:400px;" alt="image preview"/>

                        <label for="post_image">Image</label>
                        <input type="file" name="post_image" id="post_image" class="block mt-1 w-full" required />
                        @error('post_image')
                            <div class="text-red-500 mt-2 text-sm">
                                {{ $message }}
                            </div>
                        @enderror
                        <label for="description">Description</label>
                        <input type="text" name="description" id="description" class="block mt-1 w-full text-gray-800"  autocomplete="description" />
                        <label for="content"> Content</label>
                        <textarea name="content" id="content" class="block mt-1 w-full text-gray-800" required autofocus autocomplete="content" ></textarea>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mt-4 rounded">Create Post</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    let imageInput = document.getElementById('post_image');
    let previewImage = document.getElementById('preview');

    imageInput.addEventListener('change', function() {
        const file = this.files[0];

        if (file) {
            const reader = new FileReader();

            reader.addEventListener('load', function() {
                previewImage.setAttribute('src', this.result);
                previewImage.style.display = 'block';
            });

            reader.readAsDataURL(file);
        }
        });
    });
</script>