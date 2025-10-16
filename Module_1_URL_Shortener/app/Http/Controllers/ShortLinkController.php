<?php
namespace App\Http\Controllers;

use App\Models\ShortLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ShortLinkController extends Controller
{
    public function shorten(Request $request)
    {
        $request->validate([
            'original_url' => 'required|url',
            'custom_code' => 'nullable|string|max:10|regex:/^[a-zA-Z0-9_-]+$/|unique:short_links,code',
        ]);

        $code = $request->custom_code ?? Str::random(6);

        $shortLink = ShortLink::create([
            'user_id' => Auth::id(),
            'original_url' => $request->original_url,
            'code' => $code,
            'clicks' => 0,
        ]);

        return response()->json($shortLink, 201);
    }

    public function redirect($code)
    {
        $shortLink = ShortLink::where('code', $code)->firstOrFail();
        $shortLink->increment('clicks');
        return redirect($shortLink->original_url);
    }

    public function index()
    {
        $links = Auth::user()->shortLinks()->select('id', 'original_url', 'code', 'clicks', 'created_at')->get();
        return response()->json($links);
    }

    public function destroy($id)
    {
        $shortLink = Auth::user()->shortLinks()->find($id);
        if (!$shortLink) {
            return response()->json(['error' => 'Link not found'], 404);
        }
        $shortLink->delete();
        return response()->json(['message' => 'Link deleted successfully']);
    }
}   
