<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\UserModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModuleController extends Controller
{
    public function index()
    {
        return response()->json(Module::all());
    }

    public function activate($id)
    {
        $module = Module::find($id);
        if (!$module) {
            return response()->json(['error' => 'Module not found'], 404);
        }

        $userModule = UserModule::updateOrCreate(
            ['user_id' => Auth::id(), 'module_id' => $id],
            ['active' => true]
        );

        return response()->json(['message' => 'Module activated']);
    }

    public function deactivate($id)
    {
        $module = Module::find($id);
        if (!$module) {
            return response()->json(['error' => 'Module not found'], 404);
        }

        $userModule = UserModule::where('user_id', Auth::id())
                                ->where('module_id', $id)
                                ->first();

        if ($userModule) {
            $userModule->update(['active' => false]);
        }

        return response()->json(['message' => 'Module deactivated']);
    }
}   
