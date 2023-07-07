<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::share('global_var', 'Значение глобальной переменной "global_var"');
      //  View::composer('example', function($view){
		//		$view->with('composer_data', 'pass');
		//  });
			//ссылка на класс, передающий значения в шаблон
        View::composer('example', \App\View\Composers\ExampleComposer::class); 
        View::composer('mypage', \App\View\Composers\ExampleComposer::class);

		//пропись собственой директивы
			Blade::directive('nameNewDirective', function($param){
				return "<?php echo 'Прописанный текст через директиву: <b>$param</b>'; ?>";
			});

			Blade::directive('mycurrency', function(string $summ = '12', string $valute = 'rub') {
				if (!$summ || !$valute) {
				return 'Введите сумму и валюту перевода';
				}
				if ($valute == 'rub' || $valute == 'usd') {
				return "<?php echo 'На счет переведено: ' . $summ . '<b>' . $valute . '</b>'; ?>";
				}
				});
    }
}
