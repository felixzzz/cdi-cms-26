<?php

namespace App\Http\Controllers\Api;

use App\Enums\PreferenceKey;
use App\Http\Controllers\Controller;
use App\Repositories\Article\ArticleRepository;
use App\Repositories\Utility\PreferenceRepository;
use Illuminate\Http\Request;

class ApiArticleController extends Controller
{
    public function latest(ArticleRepository $articleRepository)
    {
        return $articleRepository->latestArticle(request('category_id'), request('type', 'news'), request('limit', 8));
    }

    public function latestMedia(ArticleRepository $articleRepository)
    {
        return $articleRepository->latestMedia();
    }

    public function latestSustainability(ArticleRepository $articleRepository)
    {
        return $articleRepository->latestSustainability();
    }

    public function relates(ArticleRepository $articleRepository, $ulid)
    {
        return $articleRepository->relates($ulid);
    }

    public function list(Request $request, ArticleRepository $articleRepository, $type)
    {
        return $articleRepository->findPaginated($request, $type);
    }

    public function listSustainability(Request $request, ArticleRepository $articleRepository)
    {
        return $articleRepository->findPaginatedSustainability($request);
    }

    public function detail(ArticleRepository $articleRepository, $type, $slug)
    {
        $article = $articleRepository->findBySlug($slug, $type);
        if (!$article) {
            return response()->json(['message' => 'Article not found'], 404);
        }

        return response()->json($article);
    }

    public function blogStatus()
    {
        $blogActive = (new PreferenceRepository())->find(PreferenceKey::media_blog_status->value);

        return response()->json([
            'status' => $blogActive && $blogActive->content_en == 'show' ? 'active' : 'disabled',
        ]);
    }
}
