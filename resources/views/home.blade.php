<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100"   x-data="{ search: '', results:[],
                    get getSearchResult() {
                    axios.get(`/search?search=${this.search}`)
                    .then(response => {
                        console.log(response.data);
                        this.results = response.data;
                       
                    })
                    .catch(error => {
                        console.error('Error fetching data:', error);
                    });
                }}">
                    <div
                    class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex justify-evenly items-center text-center p-2 "
                    >

                        <a type="button" href="/community" class="text-gray-100  mx-8 flex flex-col items-center">
                            <i class="fa-solid fa-magnifying-glass text-3xl" style="color: #d5d8dc;">
                            </i>
                            <small class="text-xs">explore other posts...</small>
                        </a>
                    
                        <input x-model="search" x-on:input="getSearchResult" type="text" name="search" id="search"
                            class="border-2 border-gray-300 bg-white text-gray-900 h-10 px-5 pr-16 rounded-lg text-sm focus:outline-none"
                            placeholder="Search for a user">

                        <a type="button" href="/posts/create" class="text-gray-900 dark:text-gray-100 flex flex-col pr-4">
                            <i class="fa-sharp fa-solid fa-pen text-3xl " style="color: #d8dee9;">
                            </i>
                        <small class="text-xs">Create a new post</small>
                        </a>
                    </div>
                   <ul class="flex flex-col gap-1 justify-center bg-gray-900">
                        <template x-for="user in results" :key="user.id">
                            <li class="text-gray-200 border border-gray-700 rounded p-1">
                                <a x-bind:href="`/user-profile/${user.username}`" x-text="user.username"></a>
                              </li>
                        </template>
                   </ul>
                   <div class="flex">
                       <x-following-users-sidebar :followingUser="$followingUser" />
                       <x-user-profile :user="$user"/>
                   </div>
                    
                  
            </div>
        </div>
    </div>
</x-app-layout>

