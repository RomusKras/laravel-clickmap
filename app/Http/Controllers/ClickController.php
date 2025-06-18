<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Click;

class ClickController extends Controller
{
    public function store(Request $request)
    {
        // Валидация входящих данных
        $request->validate([
            'x' => 'required|numeric',               // Координата X клика
            'y' => 'required|numeric',               // Координата Y клика
            'site_id' => 'required|exists:sites,id', // ID отслеживаемого сайта
            'timestamp' => 'required|date',          // Время клика
        ]);
        // Сохранение клика в базе данных
        Click::create([
            'x' => $request->x,
            'y' => $request->y,
            'site_id' => $request->site_id,
            'timestamp' => $request->timestamp,
        ]);
        return response()->json(['message' => 'Click tracked successfully'], 200);
    }

    public function show($siteId)
    {
        // Получение кликов для указанного сайта
        $clicks = Click::where('site_id', $siteId)->get();
        $site = \App\Models\Site::findOrFail($siteId);
        return view('sites.click_map', compact('clicks', 'site'));
    }
}
