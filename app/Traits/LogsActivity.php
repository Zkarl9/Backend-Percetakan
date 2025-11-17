<?php

namespace App\Traits;

use App\Models\ActivityLog;

trait LogsActivity
{
    protected function logActivity(string $activityType, string $description, $model): void
    {
        $indonesianTime = now()->setTimezone('Asia/Jakarta');
        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity_type' => $activityType,
            'description' => $description,
            'model_type' => get_class($model),
            'model_id' => $model->id,
            'created_at' => $indonesianTime,
            'updated_at' => $indonesianTime
        ]);
    }
}