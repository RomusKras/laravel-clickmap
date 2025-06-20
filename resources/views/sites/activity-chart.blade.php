<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Распределение активности пользователей') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Активность по часам</h3>

                <!-- Форма для выбора диапазона дат -->
                <form method="GET" action="{{ route('activity.chart', $siteId) }}" class="mb-6">
                    <div class="flex space-x-4">
                        <!-- Поле для начала диапазона -->
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700">Начальная дата</label>
                            <input type="date" id="start_date" name="start_date" value="{{ request('start_date', $startDate) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        <!-- Поле для конца диапазона -->
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700">Конечная дата</label>
                            <input type="date" id="end_date" name="end_date" value="{{ request('end_date', $endDate) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        <!-- Кнопка отправки -->
                        <div class="flex items-end">
                            <button type="submit" class="ml-4 px-4 py-2 bg-blue-500 text-white text-sm rounded hover:bg-blue-600">
                                Применить
                            </button>
                        </div>
                    </div>
                </form>

                <!-- График -->
                <canvas id="activityChart" width="800" height="400"></canvas>
            </div>
        </div>
    </div>

    <!-- Подключение Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Данные по часам
            const activityData = @json($activityData);

            // Настройка и рендеринг графика
            const ctx = document.getElementById('activityChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [
                        '0:00', '1:00', '2:00', '3:00', '4:00', '5:00', '6:00', '7:00', '8:00', '9:00',
                        '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00',
                        '18:00', '19:00', '20:00', '21:00', '22:00', '23:00'
                    ],
                    datasets: [{
                        label: 'Количество кликов по часам',
                        data: activityData,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
