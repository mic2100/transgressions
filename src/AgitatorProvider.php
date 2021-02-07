<?php

declare(strict_types=1);

namespace Transgressions;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Transgressions\Metadata\Query;

class AgitatorProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $processDigest = Agitator::getInstance();

        DB::listen(function ($sql) use ($processDigest) {
            $processDigest->addMetadata(new Query(
                $sql->sql,
                $sql->bindings,
                $sql->time
            ));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
