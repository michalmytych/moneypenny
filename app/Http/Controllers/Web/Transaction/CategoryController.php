<?php

namespace App\Http\Controllers\Web\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Transaction\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function summary()
    {
        $categories = Category::withCount('transactions')->get();

        $totalTransactions = Category::count();
        $totalTransactionsCategorized = $categories->sum('transactions_count');

        $categories = $categories->map(function ($category) use ($totalTransactionsCategorized) {
            $category->percentage = $category->transactions_count / $totalTransactionsCategorized * 100;
            return $category;
        });

        return [
            'categories' => $categories,
            'categorized_ratio' => $totalTransactionsCategorized / $totalTransactions
        ];
    }

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
