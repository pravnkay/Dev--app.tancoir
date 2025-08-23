<?php

namespace Modules\Core\Core\Listeners\Userstamps;

use Illuminate\Support\Facades\Auth;

class Deleting
{
    /**
     * When the model is being deleted.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function handle($model)
    {
        if (! $model->isUserstamping() || is_null($model->getDeletedByColumn())) {
            return;
        }

        if (is_null($model->{$model->getDeletedByColumn()})) {
            $model->{$model->getDeletedByColumn()} = Auth::id();
        }

        $dispatcher = $model->getEventDispatcher();

        $model->unsetEventDispatcher();

        $model->save();

        $model->setEventDispatcher($dispatcher);
    }
}