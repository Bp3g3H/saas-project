<?php

namespace App\Http\Controllers;

use App\Http\Resources\FeatureResource;
use App\Models\Feature;
use App\Models\UsedFeature;
use Illuminate\Http\Request;

class FeatureTwoController extends Controller
{

    public ?Feature $feature = null;

    public function __construct()
    {
        $this->feature = Feature::query()->where('route_name', 'feature2.index')->where('active', true)->firstOrFail();
    }

    public function index()
    {
        return inertia('FeatureTwo/Index', [
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

        return to_route('featureTwo.index')->with('success', $numberOne - $numberTwo);
    }
}
