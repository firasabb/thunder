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
                            {{ __('admin.email') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __('admin.sent at') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __('admin.actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($messages as $message)
                        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $message->title }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $message->email }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $message->created_at }}
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.messages.create', ['id' => $message->id]) }}"
                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ __('admin.view') }}</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
                {{ $messages->links() }}
            </div>
        </div>
    <div>
    
</x-admin-layout>
