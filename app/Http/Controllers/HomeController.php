<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slide;
use App\Models\Category;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\PostCategory;
use App\Models\Post;
use App\Models\Intro;
use App\Models\Testimonial;
use App\Models\Team;

class HomeController extends Controller
{
    public function index()
    {
        $slides = Slide::where('status',1)->where('type',1)->get();
        $sliders = Slide::where('status',1)->where("type",'2')->get();
        $intros = Intro::select("id","image","description","title")->get();
        $categories = Category::where('status',1)->where("is_home",1)->where("parent_id",0)->get();
        $serviceCategory = ServiceCategory::where('status', 1)->where("is_home",1)->where("parent_id",0)->get();
        $services = Service::where("status",1)->get();
        $homeCategories = PostCategory::where('status', 1)
            ->where('is_home', 1)
            ->with(['posts' => function ($q) {
                $q->where('status', 1)->latest()->limit(6);
            }])->get();
        $testimonials = Testimonial::where("status",1)->get();
        $teams = Team::get();
        return view('frontend.index', compact(
            'slides',
            'sliders',
            'categories',
            'serviceCategory',
            'homeCategories',
            'intros',
            'testimonials',
            'teams',
            'services'
        ));
    }
 
    public function search(Request $request)
    {
        $keyword = trim($request->input('q'));

        $posts = Post::where('status', 1)
        ->where(function ($query) use ($keyword) {
            $query->where('title', 'LIKE', "%{$keyword}%")
            ->orWhere('content', 'LIKE', "%{$keyword}%");
        })
        ->latest()
        ->paginate(10);

        return view('frontend.posts.result', compact('posts', 'keyword'));
    }
}
