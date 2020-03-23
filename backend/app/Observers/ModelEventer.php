<?php

namespace App\Observers;

use App\ScoopModel;
use Illuminate\Support\Facades\Redis;

class ModelEventer
{
    public function saved(ScoopModel $model) {
        $this->_publishEvent($model, __FUNCTION__);
    }

    // public function retrieved(ScoopModel $model) {
    //     $this->_publishEvent($model, __FUNCTION__);
    // }

    protected function _modelToChannel($model, $action) {
        $namespace = strtolower(strtr(get_class($model), '\\', '.'));
        $channel = "model.{$namespace}.{$model->id}.{$action}";
        return $channel;
    }

    protected function _publishEvent($model, $action) {
        $channel = $this->_modelToChannel($model, $action);
        return Redis::publish($channel, $model->toJson());
    }
}
