<x-admin-layout>
    <div class="p-4 sm:ml-64">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            {{ __('admin.name') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __('admin.email') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __('admin.submitted at') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __('admin.actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($entries as $entry)
                        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $entry->email }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $entry->name }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $entry->created_at }}
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.entries.show', ['id' => $entry->id]) }}"
                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
                {{ $entries->links() }}
            </div>
            <div class="m-5">
                <form action="{{ route('admin.entries.export.txt') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Export
                    </button>
                </form>
            </div>
        </div>
    <div>
    
</x-admin-layout>
