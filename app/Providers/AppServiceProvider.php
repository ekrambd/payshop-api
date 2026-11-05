<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Blade;
use Session;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use App\Repositories\Slider\SliderInterface;
use App\Repositories\Slider\SliderRepository;
use App\Repositories\Category\CategoryInterface;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Unit\UnitInterface;
use App\Repositories\Unit\UnitRepository;
use App\Repositories\Variant\VariantInterface;
use App\Repositories\Variant\VariantRepository;
use App\Repositories\Product\ProductInterface;
use App\Repositories\Product\ProductRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            SliderInterface::class,
            SliderRepository::class
        );

        $this->app->bind(
            CategoryInterface::class,
            CategoryRepository::class
        );

        $this->app->bind(
            UnitInterface::class,
            UnitRepository::class
        );

        $this->app->bind(
            VariantInterface::class,
            VariantRepository::class
        );

        $this->app->bind(
            ProductInterface::class,
            ProductRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        Schema::defaultStringLength(191);
        Session::put('currency','usd_rate');
        Blade::directive('toastr', function ($expression){
            return "<script>
                    toastr.{{ Session::get('alert-type') }}($expression)
                 </script>";
        });
    }
}
