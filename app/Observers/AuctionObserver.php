<?php

namespace App\Observers;

use App\Models\Cafes;
use App\Services\Seo\ObjectsSeoService;
use Illuminate\Support\Facades\Log;

class AuctionObserver
{
    /**
     * Handle the Cafes "created" event.
     *
     * @param  \App\Models\Cafes  $cafes
     * @return void
     */
    public function created($model)
    {
        ob_start();
        debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        $trace = ob_get_clean();

        Log::info('New model created. Full backtrace:', [
            'trace' => $trace,
        ]);
        // Здесь вы можете получить данные модели и выполнить необходимые действия
        $data = $model->toArray();

        // Выполните логирование изменений модели с помощью Log или любого другого механизма логирования
        Log::info('Data:', [
            'data' => $data,
        ]);
    }

    /**
     * Handle the Cafes "updated" event.
     *
     * @param  \App\Models\Cafes  $cafes
     * @return void
     */
    public function updated($model)
    {
        ob_start();
        debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        $trace = ob_get_clean();

        Log::info('Model changes. Full backtrace:', [
            'trace' => $trace,
        ]);
        $changes = $model->getChanges();

        // Здесь вы можете выполнить логирование изменений модели с помощью Log или любого другого механизма логирования
        Log::info('Changes:', [
            'changes' => $changes,
        ]);
    }

    /**
     * Handle the Cafes "deleted" event.
     *
     * @param  \App\Models\Cafes  $cafes
     * @return void
     */
    public function deleted(Cafes $cafes)
    {
        //
    }

    /**
     * Handle the Cafes "restored" event.
     *
     * @param  \App\Models\Cafes  $cafes
     * @return void
     */
    public function restored(Cafes $cafes)
    {
        //
    }

    /**
     * Handle the Cafes "force deleted" event.
     *
     * @param  \App\Models\Cafes  $cafes
     * @return void
     */
    public function forceDeleted(Cafes $cafes)
    {
        //
    }
}
