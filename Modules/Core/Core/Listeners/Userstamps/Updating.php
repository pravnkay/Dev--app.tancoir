<?php

namespace Modules\Core\Core\Listeners\Userstamps;

use Illuminate\Support\Facades\Auth;

class Updating
{
    /**
     * When the model is being updated.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function handle($model)
    {
        if (! $model->isUserstamping() || is_null($model->getUpdatedByColumn()) || is_null(Auth::id())) {
            return;
        }

        $model->{$model->getUpdatedByColumn()} = Auth::id();
    }
}