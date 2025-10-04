<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Transaction;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            if (Schema::hasTable('transaction')) {
                View::share('pendingTransactionsCount', Transaction::where('stage', '!=', 'completed')->count());
            } else {
                View::share('pendingTransactionsCount', 0);
            }
        } catch (\Exception $e) {
            View::share('pendingTransactionsCount', 0);
        }
    }

}
