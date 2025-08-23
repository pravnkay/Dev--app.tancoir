<?php

namespace Modules\Core\Core\Listeners\Userstamps;

class Restoring
{
    /**
     * When the model is being restored.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function handle($model)
    {
        if (! $model->isUserstamping() || is_null($model->getDeletedByColumn())) {
            return;
        }

        $model->{$model->getDeletedByColumn()} = null;
    }
}