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
                        </header>

                        <div id="click-map" style="position: relative; width: 100%; height: 500px; background: lightgray;">
                            @foreach ($clicks as $click)
                                <!-- Отображаем каждый клик точкой -->
                                <div style="
                                    position: absolute;
                                    top: {{ $click->y }}px;
                                    left: {{ $click->x }}px;
                                    width: 10px;
                                    height: 10px;
                                    background: red;
                                    border-radius: 50%;
                                    transform: translate(-50%, -50%);
                                "></div>
                            @endforeach
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
