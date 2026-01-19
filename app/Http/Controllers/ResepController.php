<?php

namespace App\Http\Controllers;

use App\Models\Resep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ResepController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private $apiKey;

    public function __construct()
    {
        $this->apiKey = env('SPOONACULAR_API_KEY');
    }

    public function index()
    {
        return view('home');
    }

    public function analyze(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:5000',
        ]);

        // ---------------------------------------------------------
        // 1. SIMULASI DETEKSI AI (Nanti diganti Python)
        // ---------------------------------------------------------
        // Spoonacular sangat pintar, kirim banyak bahan pun oke!
        $detected_ingredients = ['beef', 'chili']; 
        
        // ---------------------------------------------------------
        // 2. CARI RESEP (Spoonacular)
        // ---------------------------------------------------------
        // Menggabungkan array jadi string: "chicken,apple,cinnamon"
        $ingredients_string = implode(',', $detected_ingredients);

        $response = Http::get("https://api.spoonacular.com/recipes/findByIngredients", [
            'apiKey' => $this->apiKey,
            'ingredients' => $ingredients_string,
            'number' => 8, // Ambil 8 resep
            'ranking' => 1, // 1 = Prioritaskan bahan yang mau habis
            'ignorePantry' => true,
        ]);

        $recipes = $response->json();

        return view('result', [
            'ingredients' => $detected_ingredients,
            'recipes' => $recipes,
            'image_input' => $request->file('image')
        ]);
    }

    public function show($id)
    {
        // Spoonacular butuh request khusus untuk detail instruksi
        $response = Http::get("https://api.spoonacular.com/recipes/{$id}/information", [
            'apiKey' => $this->apiKey,
            'includeNutrition' => false,
        ]);

        $meal = $response->json();

        if (!$response->successful()) {
            return redirect('/')->with('error', 'Gagal mengambil detail resep.');
        }

        return view('detail', [
            'meal' => $meal
        ]);
    }
}
