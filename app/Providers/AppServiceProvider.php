<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use App\Models\Pengguna;
use App\Models\Tanah;
use Blade;

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
        Paginator::useBootstrap();

        // Gate::define('list-tanah', function ($tanah) {
        //     if(session('loginRole')==2){
        //         //dd($user->namaPTJ->ptj_kod_negeri);
        //         return session('loginState') === $tanah->tanah_kod_negeri;
        //     }
        //     else{
        //         return session('loginDaerah') === $tanah->tanah_kod_daerah;
        //     }
        //     return true; //if Pentadbir 
        // });

        Blade::directive('convert', function ($money) {
            return "<?php echo number_format($money, 2); ?>";
        });

        Blade::directive('duit', function ($duit) {
            return "<?php echo number_format($duit, 2); ?>";
        });

        Blade::directive('tarikh', function ($tarikh) {
            return "<?php echo date('d/m/Y', strtotime($tarikh)); ?>";
        });
        
        Blade::directive('tarikhmasa', function ($tarikh) {
            return "<?php echo date('d/m/Y H:i:s', strtotime($tarikh)); ?>";
        });
    }
}
