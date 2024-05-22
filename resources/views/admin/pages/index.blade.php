<x-admin-layout>
    <div class="p-4 sm:ml-64">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            {{ __('admin.title') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __('admin.URL') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __('admin.status') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __('admin.actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pages as $page)
                        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $page->title }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $page->url }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $page->status }}
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.pages.create', ['id' => $page->id]) }}"
                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
                {{ $pages->links() }}
            </div>
        </div>
        <div class="w-full pt-4">
            <a 
                href="{{ route('admin.pages.create') }}"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                + Create
            </a>
        </div>
    <div>
    
</x-admin-layout>
