<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Просмотр карты кликов
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
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
                            @foreach ($clicks as $click)
                                <p class="text-sm text-gray-600">Координаты: X={{ $click->x }}, Y={{ $click->y }}</p>
                            @endforeach
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
