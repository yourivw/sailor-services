<?php

namespace Yourivw\SailorServices;

use Illuminate\Support\ServiceProvider;
use Yourivw\Sailor\Facades\Sailor;
use Yourivw\Sailor\SailorService;

class SailorServicesServiceProvider extends ServiceProvider
{
    /**
     * Skip flag for HTTPS service.
     */
    public static bool $skipHttpsService = false;

    /**
     *  Skip flag for PHPMyAdmin service.
     */
    public static bool $skipPhpMyAdminService = false;

    /**
     *  Skip flag for Redis Commander service.
     */
    public static bool $skipRedisCommanderService = false;

    /**
     *  Skip flag for RedisInsight service.
     */
    public static bool $skipRedisInsightService = false;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Sailor::setSailDefaultServices(['mysql', 'mailpit']);
        Sailor::setDefaultServiceName('laravel.local');

        if (! static::$skipHttpsService) {
            Sailor::register(new HttpsService());
        }

        if (! static::$skipPhpMyAdminService) {
            SailorService::create('phpmyadmin', __DIR__.'/../stubs/phpmyadmin.stub')
                ->useDefault()
                ->register();
        }

        if (! static::$skipRedisCommanderService) {
            SailorService::create('redis-commander', __DIR__.'/../stubs/redis-commander.stub')
                ->register();
        }

        if (! static::$skipRedisInsightService) {
            Sailor::register(new RedisInsightService());
        }
    }
}
