<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class Site
 *
 * Модель для представления отслеживаемых сайтов.
 *
 * @property int         $id         Уникальный идентификатор сайта.
 * @property string      $name       Название сайта.
 * @property string      $url        URL сайта (должен быть уникальным).
 * @property Carbon|null $created_at Время создания записи.
 * @property Carbon|null $updated_at Время последнего обновления записи.
 */
class Site extends Model
{
    // Разрешенные для массового заполнения поля
    protected $fillable = ['name', 'url'];

    protected $guarded = ['id'];
}
