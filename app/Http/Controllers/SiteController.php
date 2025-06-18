<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Site;

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
}
