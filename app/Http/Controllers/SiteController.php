<?php

namespace App\Http\Controllers;

use App\Models\Click;
use Illuminate\Http\Request;
use App\Models\Site;
use Illuminate\Support\Carbon;

class SiteController extends Controller
{
    public function index()
    {
        // Список всех сайтов
        $sites = Site::all();
        return view('sites.index', compact('sites'));
    }

    public function create()
    {
        // Показать форму добавления нового сайта
        return view('sites.create');
    }

    public function store(Request $request)
    {
        // Валидация данных
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url|unique:sites'
        ]);
        // Создание нового сайта
        Site::create($request->only('name', 'url'));
        return redirect()->route('sites.index')->with('success', 'Сайт добавлен успешно!');
    }

    public function edit(Site $site)
    {
        // Показать форму редактирования сайта
        return view('sites.edit', compact('site'));
    }

    public function update(Request $request, Site $site)
    {
        // Валидация данных
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url|unique:sites,url,' . $site->id,
        ]);
        // Обновление данных сайта
        $site->update($request->only('name', 'url'));
        return redirect()->route('sites.index')->with('success', 'Сайт обновлен успешно!');
    }

    public function destroy(Site $site)
    {
        // Удаление сайта
        $site->delete();
        return redirect()->route('sites.index')->with('success', 'Сайт удален успешно!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function techSpec()
    {
        return view('tech-spec');
    }


    public function activityChart($siteId, Request $request)
    {
        // Если даты не переданы, устанавливаем диапазон по умолчанию (за неделю)
        $startDate = $request->input('start_date', Carbon::now()->subDays(7)->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        // Получение всех кликов за заданный диапазон
        $query = Click::where('site_id', $siteId);
        if ($startDate) {
            $query->whereDate('timestamp', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('timestamp', '<=', $endDate);
        }
        $clicks = $query->get();

        // Группировка по часам
        $clicksPerHour = $clicks->groupBy(function ($click) {
            return Carbon::parse($click->timestamp)->format('H'); // Извлекаем час
        })->map(function ($group) {
            return $group->count(); // Подсчитываем количество кликов
        });

        // Создание массива для всех 24 часов
        $activityData = [];
        for ($i = 0; $i < 24; $i++) {
            $hour = str_pad($i, 2, '0', STR_PAD_LEFT); // Час в формате 00
            $activityData[] = $clicksPerHour->get($hour, 0); // Если кликов в данном часу нет, устанавливаем 0
        }

        // Передаем данные в вид
        return view('sites.activity-chart', compact('activityData', 'siteId', 'startDate', 'endDate'));
    }
}
