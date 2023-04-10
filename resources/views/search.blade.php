    search
<x-app-layout>
    <div class="w-1/2">
        <form action="#" method="get">
            @csrf
            <div class="flex flex-row">
                <input type="text" placeholder="Search for..." id="query" name="query" class="block w-full rounded-md">
                <button type="submit" class="px-4 py-2 font-bold text-white bg-blue-500 rounded-md hover:bg-blue-700">Search</button>
            </div>
        </form>
    </div>
</x-app-layout>
