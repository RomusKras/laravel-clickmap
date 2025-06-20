<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Использование

Для старта использования скрипта на сайте нужно добавить на него код:

Вариант 1: Ручная инициализация

`const ClickTracker = {
config: {
endpoint: 'http://laravel.localhost/api/track-click', // Укажите URL вашего API
debug: false
},
};`

Вариант 2: Автоматическая через HTML

`<script src="tracker.js" 
        data-auto-init="true" 
        data-endpoint="http://laravel.localhost/api/track-click">
</script>`

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
