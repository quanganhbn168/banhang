<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class DashboardController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function toggleField(Request $request)
    {
        $request->validate([
            'model' => 'required|string',
            'id' => 'required|integer',
            'field' => 'required|string',
        ]);

        $modelClass = $this->resolveModelClass($request->model);
        if (!class_exists($modelClass)) {
            return response()->json(['error' => 'Model không tồn tại.'], 404);
        }

        $record = $modelClass::findOrFail($request->id);

        $field = $request->field;

        if (!array_key_exists($field, $record->getAttributes())) {
            return response()->json(['error' => 'Trường không hợp lệ.'], 422);
        }

        $record->$field = !$record->$field;
        $record->save();

        return response()->json([
            'success' => true,
            'value' => $record->$field,
            'message' => "Đã cập nhật $field thành " . ($record->$field ? '✓' : '✗')
        ]);
    }

// Helper nội bộ: resolve tên model từ string
    protected function resolveModelClass($model)
    {
        $model = Str::studly($model);
        return "App\\Models\\{$model}";
    }
}
