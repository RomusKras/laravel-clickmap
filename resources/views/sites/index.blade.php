<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sites') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                Сайты
                            </h2>
                            <a href="{{ route('sites.create') }}" class="btn btn-primary mb-3">Добавить сайт</a>
                        </header>

                        <div class="pt-4">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Название</th>
                                    <th>URL</th>
                                    <th>Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($sites as $site)
                                    <tr>
                                        <td>{{ $site->name }}</td>
                                        <td><a href="{{ $site->url }}" target="_blank">{{ $site->url }}</a></td>
                                        <td>
                                            <a href="{{ route('sites.edit', $site) }}" class="btn btn-warning btn-sm">Редактировать</a>
                                            <form action="{{ route('sites.destroy', $site) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Удалить</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
