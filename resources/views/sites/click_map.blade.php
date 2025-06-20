<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Просмотр карты кликов
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="{{-- max-w-xl --}}">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                Карта кликов для {{ $site->name }}
                            </h2>

                            <!-- Форма для выбора количества кликов на странице -->
                            <form method="GET" action="{{ route('sites.click-map', $site->id) }}">
                                <label for="per_page" class="text-sm font-medium text-gray-700">Кликов на странице:</label>
                                <select id="per_page" name="per_page" class="ml-2 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="10" @if ($perPage == 10) selected @endif>10</option>
                                    <option value="25" @if ($perPage == 25) selected @endif>25</option>
                                    <option value="50" @if ($perPage == 50) selected @endif>50</option>
                                    <option value="100" @if ($perPage == 100) selected @endif>100</option>
                                </select>
                                <button type="submit" class="ml-3 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                    Применить
                                </button>
                            </form>
                        </header>

                        <!-- Список кликов -->
                        <div class="mt-6">
                            <div class="overflow-x-auto">
                                <table class="min-w-full border-collapse border border-gray-300 bg-white">
                                    <thead class="bg-gray-50">
                                    <tr>
                                        <th class="border border-gray-300 px-6 py-3 text-left text-sm font-medium text-gray-700">
                                            Координаты
                                        </th>
                                        <th class="border border-gray-300 px-6 py-3 text-left text-sm font-medium text-gray-700">
                                            Ссылка
                                        </th>
                                        <th class="border border-gray-300 px-6 py-3 text-left text-sm font-medium text-gray-700">
                                            Target
                                        </th>
                                        <th class="border border-gray-300 px-6 py-3 text-left text-sm font-medium text-gray-700">
                                            UserAgent
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($clicks as $click)
                                        <tr class="border border-gray-300">
                                            <!-- Координаты -->
                                            <td class="px-6 py-4 text-sm text-gray-600">
                                                X={{ $click->x }}, Y={{ $click->y }}
                                            </td>

                                            <!-- Ссылка -->
                                            <td class="px-6 py-4">
                                                @if(!empty($click->full_url))
                                                    <a href="{{ $click->full_url }}" target="_blank" class="text-blue-600 hover:underline">
                                                        {{ $click->full_url }}
                                                    </a>
                                                @else
                                                    <span class="text-gray-400">Нет ссылки</span>
                                                @endif
                                            </td>

                                            <!-- Target -->
                                            <td class="px-6 py-4 text-sm text-gray-600">
                                                @if(!empty($click->target))
                                                    <code class="bg-gray-100 p-1 rounded">
                                                        {{ json_encode($click->target, JSON_UNESCAPED_UNICODE) }}
                                                    </code>
                                                @else
                                                    <span class="text-gray-400">Пусто</span>
                                                @endif
                                            </td>

                                            <!-- UserAgent -->
                                            <td class="px-6 py-4 text-sm text-gray-600">
                                                @if(!empty($click->userAgent))
                                                    <code class="bg-gray-100 p-1 rounded">
                                                        {{ $click->userAgent }}
                                                    </code>
                                                @else
                                                    <span class="text-gray-400">Нет</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- Пагинация -->
                        <div class="mt-6">
                            {{ $clicks->appends(['per_page' => $perPage])->links('pagination::tailwind') }}
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
