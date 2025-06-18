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
                                Редактировать сайт
                            </h2>
                        </header>

                        <form action="{{ route('sites.update', $site) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="name" class="form-label">Название сайта</label>
                                <input type="text" name="name" id="name" value="{{ $site->name }}" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="url" class="form-label">URL сайта</label>
                                <input type="url" name="url" id="url" value="{{ $site->url }}" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-success">Обновить</button>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

