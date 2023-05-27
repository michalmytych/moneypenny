<?php

namespace App\Http\Controllers\Transaction;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transaction\Category;

class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $baseQuery = Category::query();

        if (!$user->is_admin) {
            $baseQuery = Category::whereHas('transactions', fn($relation) => $relation
                ->where('user_id', $user->id)
            );
        }

        $categories = $baseQuery
            ->withCount('transactions')
            ->get();

        return view('category.index', compact('categories'));
    }
}
