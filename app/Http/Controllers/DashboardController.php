<?php

namespace App\Http\Controllers;

use App\Http\Resources\UsedFeatureResource;
use App\Models\UsedFeature;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function Index()
    {
        $usedFeatures = UsedFeature::query()
            ->with(['feature'])
            ->where("user_id", auth()->user()->id)
            ->latest()->paginate();

        return inertia('Dashboard', [
            'usedFeatures' => UsedFeatureResource::collection($usedFeatures)
        ]);
    }
}
