<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function index($portfolioId)
    {
        $portfolio = Portfolio::findOrFail($portfolioId);

        $service = $portfolio->services;

        if (!$service) {
            return response()->json(['message' => 'Service section not found'], 404);
        }

        return response()->json($service, 200);
    }
    public function store(Request $request, $portfolioId)
    {
        $portfolio = Portfolio::findOrFail($portfolioId);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $service = $portfolio->services()->create($request->all());
        return response()->json($service);
    }

    public function update(Request $request, $portfolioId, $serviceId)
    {
        $portfolio = Portfolio::findOrFail($portfolioId);
        $service = $portfolio->services()->find($serviceId);
        if (!$service) {
            return response()->json(['message' => 'Service not found'], 404);
        }

        $service->update($request->all());
        return response()->json(['message' => 'Service updated successfully', 'service' => $service], 200);
    }

    public function destroy($portfolioId, $serviceId)
    {
        $portfolio = Portfolio::findOrFail($portfolioId);
        $service = $portfolio->services()->find($serviceId);

        if (!$service) {
            return response()->json(['message' => 'Service not found'], 404);
        }
        $service->delete();

        return response()->json(['message' => 'this service deleted successfully']);
    }
    
    public function show($portfolioId, $serviceId)
    {
        $portfolio = Portfolio::findOrFail($portfolioId);

        $service = $portfolio->services()->find($serviceId);
        if (!$service) {
            return response()->json(['message' => 'Service not found'], 404);
        }

        return response()->json($service, 200);
    }


}