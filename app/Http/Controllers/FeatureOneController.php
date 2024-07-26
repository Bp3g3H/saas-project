<?php

namespace App\Http\Controllers;

use App\Http\Resources\FeatureResource;
use App\Models\Feature;
use App\Models\UsedFeature;
use Illuminate\Http\Request;

class FeatureOneController extends Controller
{
    public ?Feature $feature = null;

    public function __construct()
    {
        $this->feature = Feature::query()->where('route_name', 'featureOne.index')->where('active', true)->firstOrFail();
    }

    public function index()
    {
        return inertia('FeatureOne/Index', [
            'feature' => new FeatureResource($this->feature),
            'answer' => session('success'),
        ]);
    }

    public function calculate(Request $request)
    {
        $user = $request->user();
        if ($user->available_credits < $this->feature->required_credits) {
            return back();
        }

        $data = $request->validate([
            'numberOne' => ['required', 'numeric'],
            'numberTwo' => ['required', 'numeric'],
        ]);

        $numberOne = (float) $data['numberOne'];
        $numberTwo = (float) $data['numberTwo'];

        $user->decreaseCredits($this->feature->required_credits);

        UsedFeature::create([
            'feature_id' => $this->feature->id,
            'user_id' => $user->id,
            'credits' => $this->feature->required_credits,
            'data' => $data,
        ]);

        return to_route('featureOne.index')->with('success', $numberOne + $numberTwo);
    }
}
