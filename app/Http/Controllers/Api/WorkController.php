<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkController extends Controller
{
    public function index($portfolioId)
    {
        $portfolio = Portfolio::findOrFail($portfolioId);
        $work = $portfolio->works;

        if (!$work) {
            return response()->json(['message' => 'work section not found'], 404);
        }

        return response()->json($work, 200);
    }

    public function store(Request $request, $portfolioId)
    {
        $portfolio = Portfolio::findOrFail($portfolioId);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_path' => 'nullable|string',
            'link' => 'nullable|url',
        ]);
        if ($request->hasFile('image_path')) {
            $imagePath = $request->file('image_path')->store('images', 'public');
        }
    
        $workData = $request->all();
        $workData['image_path'] = $imagePath; 
    
        $work = $portfolio->works()->create($workData);     
        return response()->json($work);
    }

    public function update(Request $request, $portfolioId, $workId)
    {
        $portfolio = Portfolio::findOrFail($portfolioId);
        $work = $portfolio->works()->find($workId);
        if (!$work) {
            return response()->json(['message' => 'Work not found'], 404);
        }

        $work->update($request->all());
        return response()->json(['message' => 'Work updated successfully', 'Work' => $work], 200);
    }

    public function destroy($portfolioId, $workId)
    {
        $portfolio = Portfolio::findOrFail($portfolioId);
        $work = $portfolio->works()->find($workId);

        if (!$work) {
            return response()->json(['message' => 'Work not found'], 404);
        }
        $work->delete();

        return response()->json(['message' => 'this Work deleted successfully']);
    }
    
    public function show($portfolioId, $workId)
    {
        $portfolio = Portfolio::findOrFail($portfolioId);

        $work = $portfolio->works()->find($workId);
        if (!$work) {
            return response()->json(['message' => 'Work not found'], 404);
        }

        return response()->json($work, 200);
    }


}
