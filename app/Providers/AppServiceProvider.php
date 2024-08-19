<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;

// Without alias
use Illuminate\Support\ServiceProvider;
use KgBot\LaravelLocalization\Facades\ExportLocalizations as ExportLocalization;
use Illuminate\Database\Eloquent\Builder;


class AppServiceProvider extends ServiceProvider
{
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
        // Schema::defaultStringLength(191);
        Schema::defaultStringLength(125);
        $languages = $this->getLanguages();

        View::composer('*', function($view) use ($languages) {
            $view->with('languages', $languages);
        });

        // inside ServiceProvider
        // View::composer( 'main.home', function ( $view ) {

        //     return $view->with( [
        //         'messages' => ExportLocalization::export()->toArray(),
        //     ] );
        // } );


        Builder::macro('whereLike', function ($attributes, string $searchTerm) {
            $this->where(function (Builder $query) use ($attributes, $searchTerm) {
                foreach (array_wrap($attributes) as $attribute) {
                    $query->orWhere($attribute, 'LIKE', "%{$searchTerm}%");
                }
            });

            return $this;
        });

        Builder::macro('whereExact', function ($attributes, string $searchTerm) {
            $this->where(function (Builder $query) use ($attributes, $searchTerm) {
                foreach ($attributes as $attribute) {
                    $query->orWhere($attribute, $searchTerm);
                }
            });

            return $this;
        });


        Builder::macro('whereExactIn', function ($attributes, $searchArray) {
            $this->where(function (Builder $query) use ($attributes, $searchArray) {
                foreach ($attributes as $attribute) {
                    $query->orWhereIn($attribute, $searchArray);
                }
            });
            return $this;
        });

    }

    protected function getLanguages() {
        $es = json_decode(file_get_contents(resource_path('lang') . "/ar.json"));
        $arArray = (array) $es;

        $englishKeys = array_keys($arArray);
        $englishArray = array_combine($englishKeys, $englishKeys);

        return [
            'en' => $englishArray,
            'ar' => $arArray
        ];
    }





}
