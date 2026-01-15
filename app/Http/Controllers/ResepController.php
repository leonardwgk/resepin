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

    // public function analyze(Request $request)
    // {
    //     // 1. Validasi Input
    //     $request->validate([
    //         'image' => 'required|image|max:5000', // Max 5MB
    //     ]);

    //     // ---------------------------------------------------------
    //     // TAHAP 1: KIRIM GAMBAR KE API FLASK (PYTHON)
    //     // ---------------------------------------------------------
    //     // Asumsi API Python jalan di http://127.0.0.1:5000/analyze
    //     // Kalau belum jalan, kita pakai data DUMMY dulu biar web-nya tampil.
        
    //     /* $response = Http::attach(
    //         'image_file', file_get_contents($request->file('image')), 'photo.jpg'
    //     )->post('http://127.0.0.1:5000/analyze');
        
    //     $ingredients = $response->json()['ingredients']; 
    //     */

    //     // -- DATA DUMMY (Hapus ini nanti kalau API Python sudah ready) --
    //     $detected_ingredients = ['garlic']; // Ceritanya AI deteksi ini
    //     // ---------------------------------------------------------

        
    //     // ---------------------------------------------------------
    //     // TAHAP 2: CARI RESEP DI THEMEALDB BERDASARKAN BAHAN
    //     // ---------------------------------------------------------
    //     // Kita cari resep berdasarkan bahan UTAMA (misal bahan pertama yg terdeteksi)
    //     // TheMealDB versi gratis agak terbatas filternya, kita ambil 'filter by main ingredient'
        
    //     $main_ingredient = $detected_ingredients[0]; // Ambil 'chicken'
        
    //     $recipe_response = Http::get("https://www.themealdb.com/api/json/v1/1/filter.php", [
    //         'i' => $main_ingredient
    //     ]);

    //     $recipes = $recipe_response->json()['meals'] ?? [];

    //     // Batasi cuma tampilkan 6 resep biar rapi
    //     $recipes = array_slice($recipes, 0, 6);

    //     return view('result', [
    //         'ingredients' => $detected_ingredients,
    //         'recipes' => $recipes,
    //         'image_input' => $request->file('image') // Untuk ditampilkan lagi kalau perlu (opsional)
    //     ]);
    // }

    // public function show($id){
    //     // 1. Ambil resep dari API
    //     $response = Http::get("https://www.themealdb.com/api/json/v1/1/lookup.php", [
    //         'i' => $id
    //     ]);

    //     $meal = $response->json()['meals'][0] ?? null;

    //     if(!$meal){
    //         return redirect('/')->with('error', 'Resep tidak ditemukan.');
    //     }

    //     // 2.Format Bahan & Takaran (API TheMealDB menyimpannya terpisah-pisah)
    //     // Kita gabungkan jadi array rapi biar mudah di-looping di View
    //     $formatted_ingredients = [];
    //     for($i = 1; $i <= 20; $i++){
    //         $ingredient = $meal["strIngredient$i"];
    //         $measure = $meal["strMeasure$i"];

    //         // ambil hanya jika bahannya tidak kosong
    //         if(!empty($ingredient) && trim($ingredient) != ""){
    //             $formatted_ingredients[] = [
    //                 'item' => $ingredient,
    //                 'measure' => $measure
    //             ];
    //         }
    //     }

    //     return view('detail', [
    //         'meal' => $meal,
    //         'ingredients' => $formatted_ingredients
    //     ]);
    // }

    // // -- BARU --
    // public function analyze(Request $request)
    // {
    //     // 1. Validasi Gambar
    //     $request->validate([
    //         'image' => 'required|image|max:5000', // Maks 5MB
    //     ]);

    //     // =========================================================
    //     // TAHAP 1: SIMULASI AI (Nanti diganti API Python)
    //     // =========================================================
    //     // Saat ini kita hardcode dulu seolah-olah AI mendeteksi ini:
    //     $detected_ingredients = ['chicken']; 
        
    //     // =========================================================
    //     // TAHAP 2: LOGIKA INTERSECTION (Mencari Irisan Resep)
    //     // =========================================================
        
    //     $ing1 = $detected_ingredients[0] ?? null;
    //     $ing2 = $detected_ingredients[1] ?? null;

    //     $recipes = collect([]); 
    //     $search_status = "single"; 

    //     if ($ing1) {
    //         // Ambil Resep Bahan 1
    //         $response1 = Http::get("https://www.themealdb.com/api/json/v1/1/filter.php", ['i' => $ing1]);
    //         $list1 = collect($response1->json()['meals'] ?? []);

    //         if ($ing2) {
    //             // Ambil Resep Bahan 2
    //             $response2 = Http::get("https://www.themealdb.com/api/json/v1/1/filter.php", ['i' => $ing2]);
    //             $list2 = collect($response2->json()['meals'] ?? []);

    //             // CARI IRISANNYA (Resep yang ada di List 1 DAN List 2)
    //             $intersection = $list1->whereIn('idMeal', $list2->pluck('idMeal'));

    //             if ($intersection->isNotEmpty()) {
    //                 $recipes = $intersection;
    //                 $search_status = "perfect_match";
    //             } else {
    //                 $recipes = $list1; // Fallback ke bahan pertama
    //                 $search_status = "fallback"; 
    //             }
    //         } else {
    //             $recipes = $list1;
    //             $search_status = "single";
    //         }
    //     }

    //     // Batasi hasil maksimal 8 resep
    //     $recipes = $recipes->values()->slice(0, 8);

    //     return view('result', [
    //         'ingredients' => $detected_ingredients,
    //         'recipes' => $recipes,
    //         'status' => $search_status,
    //         'primary_ing' => $ing1,
    //         'secondary_ing' => $ing2,
    //         'image_input' => $request->file('image')
    //     ]);
    // }

    // public function searchManual($bahan)
    // {
    //     $response = Http::get("https://www.themealdb.com/api/json/v1/1/filter.php", ['i' => $bahan]);
    //     $recipes = collect($response->json()['meals'] ?? [])->slice(0, 8);

    //     return view('result', [
    //         'ingredients' => [$bahan],
    //         'recipes' => $recipes,
    //         'status' => 'manual',
    //         'primary_ing' => $bahan,
    //         'secondary_ing' => null,
    //         'image_input' => null
    //     ]);
    // }
}
