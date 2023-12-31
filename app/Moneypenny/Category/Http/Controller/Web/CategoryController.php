<?php

namespace App\Moneypenny\Category\Http\Controller\Web;

use App\Moneypenny\Category\Models\Category;
use App\Shared\Http\Controller\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $baseQuery = Category::query();

        if (!$user->is_admin) {
            $baseQuery = Category::whereHas(
                'transactions', fn($relation) => $relation
                ->where('user_id', $user->id)
            );
        }

        $categories = $baseQuery
            ->withCount('transactions')
            ->get();

        return view('category.index', compact('categories'));
    }
}
