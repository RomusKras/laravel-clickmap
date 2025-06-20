<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Сайты
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="{{-- max-w-xl --}}">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                Сайты
                            </h2>
                            <a href="{{ route('sites.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Добавить сайт
                            </a>
                        </header>

                        <div class="pt-4">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Название
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                URL
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Действия
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($sites as $site)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $site->name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600 hover:text-blue-800">
                                                    <a href="{{ $site->url }}" target="_blank" class="hover:underline">
                                                        {{ $site->url }}
                                                    </a>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <div class="flex space-x-2 justify-end">
                                                        <a href="{{ route('sites.edit', $site) }}" class="inline-flex items-center px-3 py-1 border border-yellow-500 rounded-md text-xs font-semibold text-yellow-700 bg-yellow-50 hover:bg-yellow-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                                            Редактировать
                                                        </a>
                                                        <a href="{{ route('sites.click-map', $site) }}" class="inline-flex items-center px-3 py-1 border border-yellow-500 rounded-md text-xs font-semibold text-yellow-700 bg-yellow-50 hover:bg-yellow-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                                            Карта кликов
                                                        </a>
                                                        <a href="{{ route('activity.chart', $site) }}" class="inline-flex items-center px-3 py-1 border border-yellow-500 rounded-md text-xs font-semibold text-yellow-700 bg-yellow-50 hover:bg-yellow-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                                            Графики
                                                        </a>
                                                        <form action="{{ route('sites.destroy', $site) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="inline-flex items-center px-3 py-1 border border-red-500 rounded-md text-xs font-semibold text-red-700 bg-red-50 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                                Удалить
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                            </table>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
