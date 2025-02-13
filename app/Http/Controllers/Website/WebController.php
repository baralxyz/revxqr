<?php

namespace App\Http\Controllers\Website;

use App\Models\Page;
use App\Models\Plan;
use App\Models\Config;
use App\Models\Setting;
use App\Models\Currency;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Support\Facades\Schema;
use Artesaos\SEOTools\Facades\SEOTools;
use Artesaos\SEOTools\Facades\OpenGraph;
use Illuminate\Support\Facades\Redirect;

class WebController extends Controller
{
    // Web Index
    public function webIndex()
    {
        // Queries
        $config = Config::get();

        // Check website
        if ($config[39]->config_value == "yes") {
            // Plans
            $page = Page::where('slug', 'home')->where('status', 1)->get();
            $plans = Plan::where('status', 1)->get();
            $currency = Currency::where('iso_code', $config['1']->config_value)->first();
            $setting = Setting::where('status', 1)->first();

            // Seo Tools
            SEOTools::setTitle($page[0]->meta_title);
            SEOTools::setDescription($page[0]->meta_description);

            SEOMeta::setTitle($page[0]->meta_title);
            SEOMeta::setDescription($page[0]->meta_description);
            SEOMeta::addMeta('article:section', ucfirst($page[0]->meta_title) . ' - ' . $page[0]->meta_description, 'property');
            SEOMeta::addKeyword([$page[0]->meta_keywords]);

            OpenGraph::setTitle($page[0]->meta_title);
            OpenGraph::setDescription($page[0]->meta_description);
            OpenGraph::setUrl(URL::full());
            OpenGraph::addImage([asset($setting->site_logo), 'size' => 300]);

            JsonLd::setTitle($page[0]->meta_title);
            JsonLd::setDescription($page[0]->meta_description);
            JsonLd::addImage(asset($setting->site_logo));

            // view
            return view("website.index", compact('plans', 'config', 'currency', 'setting'));
        } else {
            return redirect('/login');
        }
    }

    // Web About
    public function webAbout()
    {
        // Queries
        $config = Config::get();

        // Check website
        if ($config[39]->config_value == "yes") {
            // Queries
            $page = Page::where('slug', 'about')->where('status', 1)->get();
            $setting = Setting::where('status', 1)->first();

            if (count($page) > 0) {

                // Seo Tools
                SEOTools::setTitle($page[0]->meta_title);
                SEOTools::setDescription($page[0]->meta_description);

                SEOMeta::setTitle($page[0]->meta_title);
                SEOMeta::setDescription($page[0]->meta_description);
                SEOMeta::addMeta('article:section', ucfirst($page[0]->meta_title) . ' - ' . $page[0]->meta_description, 'property');
                SEOMeta::addKeyword([$page[0]->meta_keywords]);

                OpenGraph::setTitle($page[0]->meta_title);
                OpenGraph::setDescription($page[0]->meta_description);
                OpenGraph::setUrl(URL::full());
                OpenGraph::addImage([asset($setting->site_logo), 'size' => 300]);

                JsonLd::setTitle($page[0]->meta_title);
                JsonLd::setDescription($page[0]->meta_description);
                JsonLd::addImage(asset($setting->site_logo));

                return view("website.pages.about", compact('config', 'setting'));
            } else {
                return abort(404);
            }
        } else {
            return redirect('/login');
        }
    }

    // Web Pricing
    public function webPricing()
    {
        // Queries
        $config = Config::get();

        // Check website
        if ($config[39]->config_value == "yes") {
            // Plans
            $page = Page::where('slug', 'pricing')->where('status', 1)->get();
            $plans = Plan::where('status', 1)->get();
            $currency = Currency::where('iso_code', $config['1']->config_value)->first();
            $setting = Setting::where('status', 1)->first();

            if (count($page) > 0) {

                // Seo Tools
                SEOTools::setTitle($page[0]->meta_title);
                SEOTools::setDescription($page[0]->meta_description);

                SEOMeta::setTitle($page[0]->meta_title);
                SEOMeta::setDescription($page[0]->meta_description);
                SEOMeta::addMeta('article:section', ucfirst($page[0]->meta_title) . ' - ' . $page[0]->meta_description, 'property');
                SEOMeta::addKeyword([$page[0]->meta_keywords]);

                OpenGraph::setTitle($page[0]->meta_title);
                OpenGraph::setDescription($page[0]->meta_description);
                OpenGraph::setUrl(URL::full());
                OpenGraph::addImage([asset($setting->site_logo), 'size' => 300]);

                JsonLd::setTitle($page[0]->meta_title);
                JsonLd::setDescription($page[0]->meta_description);
                JsonLd::addImage(asset($setting->site_logo));

                return view("website.pages.pricing", compact('plans', 'config', 'currency', 'setting'));
            } else {
                return abort(404);
            }
        } else {
            return redirect('/login');
        }
    }

    // Web Contact
    public function webContact()
    {
        // Queries
        $config = Config::get();

        // Check website
        if ($config[39]->config_value == "yes") {
            // Queries
            $page = Page::where('slug', 'contact')->where('status', 1)->get();
            $setting = Setting::where('status', 1)->first();

            if (count($page) > 0) {

                // Seo Tools
                SEOTools::setTitle($page[0]->meta_title);
                SEOTools::setDescription($page[0]->meta_description);

                SEOMeta::setTitle($page[0]->meta_title);
                SEOMeta::setDescription($page[0]->meta_description);
                SEOMeta::addMeta('article:section', ucfirst($page[0]->meta_title) . ' - ' . $page[0]->meta_description, 'property');
                SEOMeta::addKeyword([$page[0]->meta_keywords]);

                OpenGraph::setTitle($page[0]->meta_title);
                OpenGraph::setDescription($page[0]->meta_description);
                OpenGraph::setUrl(URL::full());
                OpenGraph::addImage([asset($setting->site_logo), 'size' => 300]);

                JsonLd::setTitle($page[0]->meta_title);
                JsonLd::setDescription($page[0]->meta_description);
                JsonLd::addImage(asset($setting->site_logo));

                return view("website.pages.contact", compact('config', 'setting'));
            } else {
                return abort(404);
            }
        } else {
            return redirect('/login');
        }
    }

    // Web FAQs
    public function webFAQ()
    {
        // Queries
        $config = Config::get();

        // Check website
        if ($config[39]->config_value == "yes") {
            // Queries
            $page = Page::where('slug', 'faq')->where('status', 1)->get();
            $setting = Setting::where('status', 1)->first();

            if (count($page) > 0) {

                // Seo Tools
                SEOTools::setTitle($page[0]->meta_title);
                SEOTools::setDescription($page[0]->meta_description);

                SEOMeta::setTitle($page[0]->meta_title);
                SEOMeta::setDescription($page[0]->meta_description);
                SEOMeta::addMeta('article:section', ucfirst($page[0]->meta_title) . ' - ' . $page[0]->meta_description, 'property');
                SEOMeta::addKeyword([$page[0]->meta_keywords]);

                OpenGraph::setTitle($page[0]->meta_title);
                OpenGraph::setDescription($page[0]->meta_description);
                OpenGraph::setUrl(URL::full());
                OpenGraph::addImage([asset($setting->site_logo), 'size' => 300]);

                JsonLd::setTitle($page[0]->meta_title);
                JsonLd::setDescription($page[0]->meta_description);
                JsonLd::addImage(asset($setting->site_logo));

                return view("website.pages.faq", compact('config', 'setting'));
            } else {
                return abort(404);
            }
        } else {
            return redirect('/login');
        }
    }

    // Web Privacy
    public function webPrivacy()
    {
        // Queries
        $config = Config::get();

        // Check website
        if ($config[39]->config_value == "yes") {
            // Queries
            $page = Page::where('slug', 'privacy-policy')->where('status', 1)->get();
            $setting = Setting::where('status', 1)->first();

            if (count($page) > 0) {

                // Seo Tools
                SEOTools::setTitle($page[0]->meta_title);
                SEOTools::setDescription($page[0]->meta_description);

                SEOMeta::setTitle($page[0]->meta_title);
                SEOMeta::setDescription($page[0]->meta_description);
                SEOMeta::addMeta('article:section', ucfirst($page[0]->meta_title) . ' - ' . $page[0]->meta_description, 'property');
                SEOMeta::addKeyword([$page[0]->meta_keywords]);

                OpenGraph::setTitle($page[0]->meta_title);
                OpenGraph::setDescription($page[0]->meta_description);
                OpenGraph::setUrl(URL::full());
                OpenGraph::addImage([asset($setting->site_logo), 'size' => 300]);

                JsonLd::setTitle($page[0]->meta_title);
                JsonLd::setDescription($page[0]->meta_description);
                JsonLd::addImage(asset($setting->site_logo));

                return view("website.pages.privacy", compact('config', 'setting'));
            } else {
                return abort(404);
            }
        } else {
            return redirect('/login');
        }
    }

    // Web Refund
    public function webRefund()
    {
        // Queries
        $config = Config::get();

        // Check website
        if ($config[39]->config_value == "yes") {
            // Queries
            $page = Page::where('slug', 'refund-policy')->where('status', 1)->get();
            $setting = Setting::where('status', 1)->first();

            if (count($page) > 0) {

                // Seo Tools
                SEOTools::setTitle($page[0]->meta_title);
                SEOTools::setDescription($page[0]->meta_description);

                SEOMeta::setTitle($page[0]->meta_title);
                SEOMeta::setDescription($page[0]->meta_description);
                SEOMeta::addMeta('article:section', ucfirst($page[0]->meta_title) . ' - ' . $page[0]->meta_description, 'property');
                SEOMeta::addKeyword([$page[0]->meta_keywords]);

                OpenGraph::setTitle($page[0]->meta_title);
                OpenGraph::setDescription($page[0]->meta_description);
                OpenGraph::setUrl(URL::full());
                OpenGraph::addImage([asset($setting->site_logo), 'size' => 300]);

                JsonLd::setTitle($page[0]->meta_title);
                JsonLd::setDescription($page[0]->meta_description);
                JsonLd::addImage(asset($setting->site_logo));

                return view("website.pages.refund", compact('config', 'setting'));
            } else {
                return abort(404);
            }
        } else {
            return redirect('/login');
        }
    }

    // Web Terms
    public function webTerms()
    {
        // Queries
        $config = Config::get();

        // Check website
        if ($config[39]->config_value == "yes") {
            // Queries
            $page = Page::where('slug', 'terms-and-conditions')->where('status', 1)->get();
            $setting = Setting::where('status', 1)->first();

            if (count($page) > 0) {

                // Seo Tools
                SEOTools::setTitle($page[0]->meta_title);
                SEOTools::setDescription($page[0]->meta_description);

                SEOMeta::setTitle($page[0]->meta_title);
                SEOMeta::setDescription($page[0]->meta_description);
                SEOMeta::addMeta('article:section', ucfirst($page[0]->meta_title) . ' - ' . $page[0]->meta_description, 'property');
                SEOMeta::addKeyword([$page[0]->meta_keywords]);

                OpenGraph::setTitle($page[0]->meta_title);
                OpenGraph::setDescription($page[0]->meta_description);
                OpenGraph::setUrl(URL::full());
                OpenGraph::addImage([asset($setting->site_logo), 'size' => 300]);

                JsonLd::setTitle($page[0]->meta_title);
                JsonLd::setDescription($page[0]->meta_description);
                JsonLd::addImage(asset($setting->site_logo));

                return view("website.pages.terms", compact('config', 'setting'));
            } else {
                return abort(404);
            }
        } else {
            return redirect('/login');
        }
    }

    // Custom pages
    public function customPage($id)
    {
        // Queries
        $config = Config::get();

        // Check website
        if ($config[39]->config_value == "yes") {
            // Get page details
            $page = Page::where('slug', $id)->where('status', 1)->first();
            $setting = Setting::where('status', 1)->first();

            if (!empty($page)) {
                // Seo Tools
                SEOTools::setTitle($page->meta_title);
                SEOTools::setDescription($page->meta_description);

                SEOMeta::setTitle($page->meta_title);
                SEOMeta::setDescription($page->meta_description);
                SEOMeta::addMeta('article:section', ucfirst($page->meta_title) . ' - ' . $page->meta_description, 'property');
                SEOMeta::addKeyword([$page->keywords]);

                OpenGraph::setTitle($page->meta_title);
                OpenGraph::setDescription($page->meta_description);
                OpenGraph::setUrl(URL::full());
                OpenGraph::addImage([asset($setting->site_logo), 'size' => 300]);

                JsonLd::setTitle($page->meta_title);
                JsonLd::setDescription($page->meta_description);
                JsonLd::addImage(asset($setting->site_logo));

                // View page
                return view("website.pages.custom-page", compact('page', 'config', 'setting'));
            } else {
                return abort(404);
            }
        } else {
            return redirect('/login');
        }
    }
}
