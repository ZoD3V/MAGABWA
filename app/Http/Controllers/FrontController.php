<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Category;
use App\Models\ArticleNews;
use App\Models\BannerAdvertisement;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        // Mengambil semua kategori
        $categories = Category::all();

        // Mengambil artikel yang tidak featured, dengan relasi kategori, diurutkan berdasarkan terbaru
        $articles = ArticleNews::with(['category'])
            ->where('is_featured', 'not_featured')
            ->where('is_approve', 'approve')
            ->latest()
            ->take(3)
            ->get();

        // Mengambil artikel yang featured secara acak, dengan relasi kategori
        $featured_articles = ArticleNews::with(['category'])
            ->where('is_featured', 'featured')
            ->where('is_approve', 'approve')
            ->inRandomOrder()
            ->take(3)
            ->get();

        // Mengambil semua penulis
        $authors = Author::all();

        // Mengambil iklan banner yang aktif secara acak
        $bannerads = BannerAdvertisement::where('is_active', 'active')
            ->where('type', 'banner')
            ->inRandomOrder()
            ->first();

        // Mengambil artikel dengan kategori 'Entertainment' yang tidak featured
        $entertainment_articles = ArticleNews::with(['category'])
            ->whereHas('category', function ($query) {
                $query->where('name', 'Entertainment');
            })
            ->where('is_featured', 'not_featured')
            ->where('is_approve', 'approve')
            ->latest()
            ->take(6)
            ->get();

        // Mengambil artikel yang featured dengan kategori 'Entertainment' secara acak
        $entertainment_featured_articles = ArticleNews::with(['category'])
            ->whereHas('category', function ($query) {
                $query->where('name', 'Entertainment');
            })
            ->where('is_featured', 'featured')
            ->inRandomOrder()
            ->first();

        // Mengirim data ke view
        return view('front.index', compact(
            'categories',
            'articles',
            'authors',
            'featured_articles',
            'bannerads',
            'entertainment_articles',
            'entertainment_featured_articles'
        ));
    }

    public function category(Category $category)
    {
        // Mengambil semua kategori
        $categories = Category::all();

        // Mengambil iklan banner yang aktif secara acak
        $bannerads = BannerAdvertisement::where('is_active', 'active')
            ->where('type', 'banner')
            ->inRandomOrder()
            ->first();

        // Mengirim data ke view
        return view('front.category', compact('category', 'categories', 'bannerads'));
    }

    public function author(Author $author)
    {
        // Mengambil semua kategori
        $categories = Category::all();

        // Mengambil iklan banner yang aktif secara acak
        $bannerads = BannerAdvertisement::where('is_active', 'active')
            ->where('type', 'banner')
            ->inRandomOrder()
            ->first();

        return view('front.author', compact('categories', 'author', 'bannerads'));
    }

    public function search(Request $request)
    {
        $request->validate([
            'keyword' => ['required', 'string', 'max:255'],
        ]);

        $categories = Category::all();
        $keyword = $request->keyword;

            $articles = ArticleNews::with(['category', 'author'])
            ->where('name', 'like', '%' . $keyword . '%')
            ->where('is_approve', 'approve')
            ->paginate(6);


        return view('front.search', compact('articles', 'keyword', 'categories'));
    }

    public function details(ArticleNews $articleNews)
    {
        $categories = Category::all();

        $articles = ArticleNews::with(['category'])
            ->where('is_featured', 'not_featured')
            ->where('is_approve', 'approve')
            ->where('id', '!=', $articleNews->id)
            ->latest()
            ->take(3)
            ->get();

        $bannerads = BannerAdvertisement::where('is_active', 'active')
            ->where('type', 'banner')
            ->inRandomOrder()
            ->first();

        $square_ads = BannerAdvertisement::where('type', 'square')
            ->where('is_active', 'active')
            ->inRandomOrder()
            ->take(2)
            ->get();

        if ($square_ads->count() < 2) {
            $square_ads_1 = $square_ads->first();
            $square_ads_2 = $square_ads->first();
        } else {
            $square_ads_1 = $square_ads->get(0);
            $square_ads_2 = $square_ads->get(1);
        }

        $author_news = ArticleNews::where('author_id', $articleNews->author_id)
            ->where('id', '!=', $articleNews->id)
            ->inRandomOrder()
            ->get();


        return view('front.details', compact('author_news', 'square_ads_1', 'square_ads_2', 'articleNews', 'categories', 'articles', 'bannerads'));
    }

}
