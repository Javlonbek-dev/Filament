<?php

namespace App\Providers;

use Blueprint\Models\Model;
use Filament\Tables\Actions\CreateAction;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
    }

    public function boot(): void
    {
        CreateAction::configureUsing(function ($action){
            return $action->slideOver();
        });
    }
}
