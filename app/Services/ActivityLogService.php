<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogService
{
    /**
     * Log an administrative action.
     *
     * @param string $action Example: 'create', 'update', 'delete', 'login'
     * @param string $description Human readable description of the action
     * @param string|null $modelType The class name of the model being acted upon
     * @param int|null $modelId The ID of the model being acted upon
     * @param array $properties Additional context or old/new values
     * @return ActivityLog
     */
    public static function log($action, $description, $modelType = null, $modelId = null, array $properties = [])
    {
        return ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'model_type' => $modelType,
            'model_id' => $modelId,
            'description' => $description,
            'properties' => $properties,
            'ip_address' => Request::ip(),
        ]);
    }
}
