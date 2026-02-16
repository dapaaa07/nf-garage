<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
// Pastikan semua model produk di-import dengan benar
use App\Models\Oli;
use App\Models\RemModel;
use App\Models\InternalModel;
use App\Models\LainnyaModel;

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
        // PERBAIKAN: Gunakan enforceMorphMap untuk memastikan map selalu digunakan.
        // Ini akan menyelesaikan error "Class 'rem' not found".
        Relation::enforceMorphMap([
            'oli' => Oli::class,
            'rem' => RemModel::class,
            'internal' => InternalModel::class,
            'lainnya' => LainnyaModel::class,
        ]);
    }
}
