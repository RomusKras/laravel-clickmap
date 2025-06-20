<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Тех. задание') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="{{-- max-w-xl --}}">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                Техническое задание
                            </h2>
                        </header>

                        <div class="pt-4">
                            <article class="prose">
                                <h3 class="font-semibold">Описание:</h3>
                                <ol class="list-disc pl-6">
                                    <li>JS-код, который можно внедрить на любой сайт.
                                        Скрипт отслеживает дату, время и координаты кликов, передаёт их в нашу админку.</li>
                                    <li>
                                        Сайт-админка на laravel, на котором можно увидеть информацию для каждого сайта, который мы мониторим:
                                        <ul>
                                            <li> - список всех отслеживаемых сайтов, с возможностью добавления нового</li>
                                            <li>- карта кликов (что-то простое, похожее на Яндекс-метрику)</li>
                                            <li>- график распределения активности пользователя по часам (в какие часы сколько было кликов)</li>
                                        </ul>
                                    </li>
                                </ol>

                            </article>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
