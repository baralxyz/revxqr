<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Plan;
use App\Models\User;
use App\Models\Medias;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MediaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    // All user media
    public function media()
    {
        // Get plan details
        $active_plan = Plan::where('id', Auth::user()->plan_id)->first();
        // Get user details
        $plan = User::where('id', Auth::user()->id)->first();

        if ($active_plan != null) {
            // Get media images
            $media = Medias::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->paginate(8);
            $settings = Setting::where('status', 1)->first();

            // View media
            return view('user.pages.media.index', compact('media', 'settings'));
        } else {
            // Page redirect
            return redirect()->route('user.plans');
        }
    }

    // Add media
    public function addMedia()
    {
        // Queries
        $settings = Setting::where('status', 1)->first();

        // Check validity
        $validity = User::where('id', Auth::user()->id)->whereDate('plan_validity', '>=', Carbon::now())->count();

        // Add media
        if ($validity == 1) {
            return view('user.pages.media.add', compact('settings'));
        } else {
            // Redirect
            return redirect()->route('user.media')->with('failed', trans('Your plan is over. Choose your plan renewal or new package and use it.'));
        }
    }

    // Upload media
    public function uploadMedia(Request $request)
    {
        // Request file
        $image = $request->file('file');

        // Generate ID
        $uniqid = uniqid();

        // Image name
        $imageName = Auth::user()->id . '-' . $uniqid . '.' . $image->extension();
        $media_url = "/images/" . Auth::user()->id . '-' . $uniqid . '.' . $image->extension();
        $image->move(public_path('images'), $imageName);

        $card = new Medias();
        $card->user_id = Auth::user()->id;
        $card->media_name = $image->getClientOriginalName();
        $card->media_url = $media_url;
        $card->save();

        return response()->json(['success' => $imageName]);
    }

    // Delete media
    public function deleteMedia($mid)
    {
        $media_data = Medias::where('user_id', Auth::user()->id)->where('id', $mid)->first();
        if ($media_data != null) {
            Medias::where('user_id', Auth::user()->id)->where('id', $mid)->delete();

            // Page redirect
            return redirect()->route('user.media')->with('success', trans('Media file removed!'));
        } else {
            // Page redirect
            return redirect()->route('user.media')->with('failed', trans('Media not found!'));
        }
    }
}
