<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AboutController extends Controller
{

    public function store(Request $request, $portfolioId)
    {
        $portfolio = Portfolio::findOrFail($portfolioId);
        $this->authorizeAccess($portfolio);

        $request->validate([
            'content' => 'required|string',
        ]);

        $about = $portfolio->about;
        if ($about) {
            $about->update($request->all());
            return response()->json(['message' => 'About section updated successfully', 'about' => $about], 200);

        } else {
            $about = $portfolio->about()->create($request->all());
            return response()->json(['message' => 'About section created successfully', 'about' => $about], 201);

        }
    }


    public function show($portfolioId)
    {
        $portfolio = Portfolio::findOrFail($portfolioId);
        $this->authorizeAccess($portfolio);

        $about = $portfolio->about;

        if (!$about) {
            return response()->json(['message' => 'About section not found'], 404);
        }

        return response()->json($about, 200);
    }

    public function destroy($portfolioId)
    {
        $portfolio = Portfolio::findOrFail($portfolioId);
        $this->authorizeAccess($portfolio);

        $about = $portfolio->about;

        if (!$about) {
            return response()->json(['message' => 'About section not found'], 404);
        }

        $about->delete();

        return response()->json(['message' => 'About section deleted successfully'], 200);
    }


    protected function authorizeAccess(Portfolio $portfolio)
    {
        if ($portfolio->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
    }
}