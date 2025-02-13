<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use App\Models\Config;
use App\Models\Medias;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mews\Purifier\Facades\Purifier;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
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

    //  Pages
    public function index()
    {
        // Static pages
        $pages = Page::where('slug', 'home')->orWhere('slug', 'about')->orWhere('slug', 'contact')
            ->orWhere('slug', 'faq')->orWhere('slug', 'pricing')->orWhere('slug', 'privacy-policy')
            ->orWhere('slug', 'refund-policy')->orWhere('slug', 'terms-and-conditions')->groupBy('slug')->get(DB::raw('count(*) as total, pages.*'));
        // Custom pages
        $custom_pages = Page::groupBy('slug')->where('slug', '!=', 'home')->where('slug', '!=', 'about')->where('slug', '!=', 'contact')
            ->where('slug', '!=', 'faq')->where('slug', '!=', 'pricing')->where('slug', '!=', 'privacy-policy')
            ->where('slug', '!=', 'refund-policy')->where('slug', '!=', 'terms-and-conditions')->get(DB::raw('count(*) as total, pages.*'));

        $settings = Setting::first();
        $config = Config::get();

        // View
        return view('admin.pages.pages.index', compact('pages', 'custom_pages', 'settings', 'config'));
    }

    // Add page
    public function addPage()
    {
        // View
        return view('admin.pages.pages.add');
    }

    // Save page
    public function savePage(Request $request)
    {
        // Validation
        $validator = $request->validate([
            'name' => 'required',
            'title' => 'required',
            'body' => 'required',
            'meta_title' => 'required',
            'meta_description' => 'required',
            'meta_keywords' => 'required'
        ]);

        // Update page
        $page = new Page();
        $page->name = $request->name;
        $page->title = $request->title;
        $page->slug = $request->slug;
        $page->body = Purifier::clean($request->body);
        $page->meta_title = ucfirst($request->meta_title);
        $page->meta_description = $request->meta_description;
        $page->meta_keywords = ucfirst($request->meta_keywords);
        $page->save();

        return redirect()->back()->with('success', trans('Page Saved Successfully!'));
    }

    // Edit custom page
    public function editCustomPage($id)
    {
        // Get page details
        $page = Page::where('id', $id)->first();
        $settings = Setting::first();
        $config = Config::get();

        // Check data
        if ($page) {
            // View
            return view('admin.pages.pages.custom-edit', compact('page', 'settings', 'config'));
        } else {
            return redirect()->route('admin.pages')->with('failed', trans('No data available'));
        }
    }

    // Edit page
    public function editPage($id)
    {
        // Get page details
        $sections = Page::where('slug', $id)->get();
        $settings = Setting::first();
        $config = Config::get();

        // Check data
        if (count($sections) > 0) {
            // View
            return view('admin.pages.pages.edit', compact('sections', 'settings', 'config'));
        } else {
            return redirect()->route('admin.pages')->with('failed', trans('No data available'));
        }
    }

    // Update page
    public function updatePage(Request $request, $id)
    {
        // Update page
        $sections = Page::where('slug', $id)->get();
        for ($i = 0; $i < count($sections); $i++) {
            $safe_section_content = $request->input('section' . $i);
            Page::where('slug', $id)->where('id', $sections[$i]->id)->update([
                'body' => $safe_section_content, 'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description, 'meta_keywords' => $request->meta_keywords
            ]);
        }

        // Page redirect
        return redirect()->route('admin.pages')->with('success', trans('Website Content Updated Successfully!'));
    }

    // Update custom page
    public function updateCustomPage(Request $request)
    {
        // Validation
        $validator = $request->validate([
            'name' => 'required',
            'title' => 'required',
            'body' => 'required',
            'meta_title' => 'required',
            'meta_description' => 'required',
            'meta_keywords' => 'required'
        ]);

        // Update page
        $page = Page::findOrFail($request->page_id);
        $page->name = $request->name;
        $page->title = $request->title;
        $page->slug = $request->slug;
        $page->body = Purifier::clean($request->body);
        $page->meta_title = ucfirst($request->meta_title);
        $page->meta_description = ucfirst($request->meta_description);
        $page->meta_keywords = $request->meta_keywords;
        $page->save();

        return redirect()->back()->with('success', trans('Page Updated Successfully!'));
    }

    // Status Page
    public function statusPage(Request $request)
    {
        // Get plan details
        $page_details = Page::where('id', $request->query('id'))->first();

        // Check status
        if ($page_details->status == 0) {
            $status = 1;
        } else {
            $status = 0;
        }

        // Update status
        Page::where('id', $request->query('id'))->update(['status' => $status]);
        return redirect()->back()->with('success', trans('Page Status Updated Successfully!'));
    }

    // Disable Page
    public function disablePage(Request $request)
    {
        // Get plan details
        $page_details = Page::where('slug', $request->query('id'))->first();

        // Check status
        if ($page_details->status == 0) {
            $status = 1;
        } else {
            $status = 0;
        }

        // Update status
        Page::where('slug', $request->query('id'))->update(['status' => $status]);

        return redirect()->route('admin.pages')->with('success', trans('Page Status Updated Successfully!'));
    }

    // Delete Page
    public function deletePage(Request $request)
    {
        // Update status
        Page::where('id', $request->query('id'))->delete();
        return redirect()->back()->with('success', trans('Page Deleted Successfully!'));
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('image')) {
            $user = Auth::user(); // Assuming you have authentication set up
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $imageName);

            $media = new Medias();
            $media->media_name = $imageName;
            $media->media_url = Storage::url('images/' . $imageName);
            $media->user_id = $user->id;
            $media->save();

            return response()->json(['url' => $media->url]);
        }
        return response()->json(['error' => trans('No image uploaded.')], 400);
    }
}
