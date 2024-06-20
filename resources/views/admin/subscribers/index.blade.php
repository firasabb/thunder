<x-admin-layout>
    <div class="p-4 sm:ml-64">

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            {{ __('admin.email') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __('admin.created at') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subscribers as $subscriber)
                        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                            <td class="px-6 py-4">
                                {{ $subscriber->email }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $subscriber->created_at }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $subscribers->links() }}
        </div>
    <div>
    
</x-admin-layout>
