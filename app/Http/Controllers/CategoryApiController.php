<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryMasuk;
use Illuminate\Http\Request;

class CategoryApiController extends Controller
{
    public function index()
    {
        $categories = Category::where('user_id', null)->orWhere('user_id', auth()->id())->get();
        if ($categories) {
            return response()->json([
                'success' => true,
                'categories' => $categories
            ]);
        }
        return response()->json(['success' => false, 'message' => 'ERROR'], 500);
    }
    public function indexMasuk()
    {
        $categories = CategoryMasuk::where('user_id', null)->orWhere('user_id', auth()->id())->get();
        if ($categories) {
            return response()->json([
                'success' => true,
                'categories' => $categories
            ]);
        }
        return response()->json(['success' => false, 'message' => 'ERROR'], 500);
    }
    public function detail(Category $category)
    {
        if ($category) {
            return response()->json([
                'success' => true,
                'name' => $category->nama,
                'persen' => $category->persen(),
                'color' => $category->bgColor()
            ]);
        }
        return response()->json(['success' => false, 'message' => 'ERROR'], 500);
    }
    public function detailMasuk(CategoryMasuk $categoryMasuk)
    {
        if ($categoryMasuk) {
            return response()->json([
                'success' => true,
                'name' => $categoryMasuk->nama,
                'persen' => $categoryMasuk->persen(),
                'color' => $categoryMasuk->bgColor()
            ]);
        }
        return response()->json(['success' => false, 'message' => 'ERROR'], 500);
    }
}
