<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SocialLinkController extends Controller
{
    public function index($portfolioId)
    {
        $portfolio = Portfolio::findOrFail($portfolioId);

        $SocialLink = $portfolio->SocialLinks;

        if (!$SocialLink) {
            return response()->json(['message' => 'SocialLink section not found'], 404);
        }

        return response()->json($SocialLink, 200);
    }
    public function store(Request $request, $portfolioId)
    {
        $portfolio = Portfolio::findOrFail($portfolioId);
        $request->validate([
        'platform' => 'required|string|max:255',
        'url' => 'required|url|max:255',
        ]);
        $SocialLink = $portfolio->SocialLinks()->create($request->all());
        return response()->json($SocialLink, 200);
    }

    public function update(Request $request, $portfolioId, $SocialLinkId)
    {
        $portfolio = Portfolio::findOrFail($portfolioId);
        $SocialLink = $portfolio->SocialLinks()->find($SocialLinkId);
        if (!$SocialLink) {
            return response()->json(['message' => 'SocialLink not found'], 404);
        }

        $SocialLink->update($request->all());
        return response()->json(['message' => 'SocialLink updated successfully', 'SocialLink' => $SocialLink], 200);
    }

    public function destroy($portfolioId, $SocialLinkId)
    {
        $portfolio = Portfolio::findOrFail($portfolioId);
        $SocialLink = $portfolio->SocialLinks()->find($SocialLinkId);

        if (!$SocialLink) {
            return response()->json(['message' => 'SocialLink not found'], 404);
        }
        $SocialLink->delete();

        return response()->json(['message' => 'this SocialLink deleted successfully']);
    }
    public function show($portfolioId, $SocialLinkId)
    {
        $portfolio = Portfolio::findOrFail($portfolioId);
        $SocialLink = $portfolio->SocialLinks()->find($SocialLinkId);
        if (!$SocialLink) {
            return response()->json(['message' => 'SocialLink not found'], 404);
        }
        return response()->json($SocialLink, 200);
    }

}