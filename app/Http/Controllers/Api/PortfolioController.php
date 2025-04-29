<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PortfolioController extends Controller
{
    public function index()
    {
        $portfolio = portfolio::all();
        return response()->json($portfolio, 200);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'profile_image' => 'image|required',
        ]);
        $imageName = $request->file("profile_image")->store('image',"public");
        $portfolio = new Portfolio();
        $portfolio->title = $validatedData['title'];
        $portfolio->profile_image = $imageName;
        $portfolio->user_id=auth()->id();
        $portfolio->save();
        return response()->json(["message" => "portfolio added", "portfolio" => $portfolio], 201);
    }
    public function show($id)
    {
        $portfolio = portfolio::where("id", $id)->first();
        if ($portfolio) {
            return response()->json($portfolio, 200);
        }
        return response()->json(["message" => "portfolio not found"], 404);
    }
    public function update(Request $request, $id)
    {
            $validatedData = $request->validate([
                'title' => 'required|string',
                'profile_image' => 'image',
            ]);
    
            $portfolio = Portfolio::find($id);
            if (!$portfolio) {
                Log::error("Portfolio not found for ID: $id");
                return response()->json(["message" => "Portfolio not found"], 404);
            }
    
            if ($request->hasFile('profile_image')) {
    
                $imageName = $request->file("profile_image")->store('image',"public");
    
                $portfolio->profile_image = $imageName;
            } else {
                Log::warning("No profile image uploaded for portfolio ID: $id");
            }
            $portfolio->title = $validatedData['title'];
            $portfolio->save();    
            return response()->json(["message" => "Portfolio updated", "portfolio" => $portfolio], 200);
        
    } 
    public function destroy($id)
    {
        $portfolio = Portfolio::find($id);
        if (!$portfolio) {
            Log::error("Portfolio not found for ID: $id");
            return response()->json(["message" => "Portfolio not found"], 404);
        }
    
        $portfolio->delete();
        return response()->json(["message" => "Portfolio deleted successfully"], 200);
    }
}
