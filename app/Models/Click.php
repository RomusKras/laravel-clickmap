<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class Click
 *
 * Модель для представления кликов пользователей на сайте.
 *
 * @property int         $id          Уникальный идентификатор клика.
 * @property int         $site_id     Идентификатор связанного сайта (FK).
 * @property float       $x           Координата X клика.
 * @property float       $y           Координата Y клика.
 * @property string      $timestamp   Время клика (формат ISO 8601).
 * @property Carbon|null $created_at Время создания записи.
 * @property Carbon|null $updated_at Время обновления записи.
 */
class Click extends Model
{
    protected $fillable = ['site_id', 'x', 'y', 'timestamp'];
}
