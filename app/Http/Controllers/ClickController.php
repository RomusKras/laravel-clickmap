<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Http\Request;
use App\Models\Click;

class ClickController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Валидация, чтобы `clicks` был массивом
            $request->validate([
                'clicks' => 'required|array', // Убедитесь, что `clicks` — это массив
                'clicks.*.x' => 'required|numeric',
                'clicks.*.y' => 'required|numeric',
                'clicks.*.timestamp' => 'required|date',
                'clicks.*.url' => 'required|string',
                'clicks.*.userAgent' => 'required|string',
                'clicks.*.target' => 'required|array', // target должен быть JSON
            ]);
            // Извлечение уникальных доменов (протокол + хост) из массива `clicks`
            $uniqueDomains = collect($request->input('clicks'))->map(function ($click) {
                $parsedUrl = parse_url($click['url']);
                return isset($parsedUrl['scheme'], $parsedUrl['host'])
                    ? $parsedUrl['scheme'] . '://' . $parsedUrl['host']
                    : null;
            })->unique()->filter(); // Убираем null-значения
            // Получение сайтов из таблицы `sites` по `url`
            $sites = Site::whereIn('url', $uniqueDomains)->get()->keyBy('url');
            // Обработка кликов
            $clicksToSave = collect($request->input('clicks'))->map(function ($click) use ($sites) {
                $parsedUrl = parse_url($click['url']);
                $domain = isset($parsedUrl['scheme'], $parsedUrl['host'])
                    ? $parsedUrl['scheme'] . '://' . $parsedUrl['host']
                    : null;
                $site = $sites->get($domain); // Найти site_id по домену
                return [
                    'x' => $click['x'],
                    'y' => $click['y'],
                    'timestamp' => $click['timestamp'],
                    'site_id' => $site ? $site->id : null, // Если сайт не найден, возвращаем null
                    'full_url' => $click['url'], // Полный URL клика
                    'userAgent' => $click['userAgent'], // User-Agent пользователя
                    'target' => json_encode($click['target']), // Преобразуем target в JSON
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            });
            // Проверка на наличие site_id
            if ($clicksToSave->contains(fn ($click) => $click['site_id'] === null)) {
                return response()->json(['error' => 'One or more clicks have an invalid or missing site_id'], 422);
            }
            // Сохранение данных в таблицу clicks
            Click::insert($clicksToSave->toArray());
            return response()->json(['message' => 'Clicks tracked successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show($siteId, Request $request)
    {
        // Получаем количество кликов на странице (по умолчанию 50)
        $perPage = $request->input('per_page', 50);

        // Получение кликов для указанного сайта с пагинацией
        $clicks = Click::where('site_id', $siteId)->paginate($perPage);

        // Получаем информацию о сайте
        $site = Site::findOrFail($siteId);

        return view('sites.click_map', compact('clicks', 'site', 'perPage'));
    }
}
