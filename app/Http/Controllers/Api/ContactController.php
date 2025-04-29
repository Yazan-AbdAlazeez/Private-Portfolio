<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function store(Request $request, $portfolioId)
    {
        $portfolio = Portfolio::findOrFail($portfolioId);
        $this->authorizeAccess($portfolio);

        $request->validate([
        'email' => 'required|email|max:255',
        'phone' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:255',
        'additional_info' => 'nullable|string',
        ]);

        $contact = $portfolio->contact;
        if ($contact) {
            $contact->update($request->all());
        } else {
            $contact = $portfolio->contact()->create($request->all());
        }

        return response()->json($contact, 200);
    }

    public function show($portfolioId)
    {
        $portfolio = Portfolio::findOrFail($portfolioId);
        $this->authorizeAccess($portfolio);

        $contact = $portfolio->contact;

        if (!$contact) {
            return response()->json(['message' => 'Contact section not found'], 404);
        }

        return response()->json($contact, 200);
    }

    public function destroy($portfolioId)
    {
        $portfolio = Portfolio::findOrFail($portfolioId);
        $this->authorizeAccess($portfolio);

        $contact = $portfolio->contact;

        if (!$contact) {
            return response()->json(['message' => 'Contact section not found'], 404);
        }

        $contact->delete();

        return response()->json(['message' => 'Contact section deleted successfully'], 200);
    }


    protected function authorizeAccess(Portfolio $portfolio)
    {
        if ($portfolio->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
    }
}
