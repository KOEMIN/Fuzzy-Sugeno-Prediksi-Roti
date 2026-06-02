<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FuzzySugenoService;

class FuzzyController extends Controller
{
    protected $fuzzyService;

    public function __construct(FuzzySugenoService $fuzzyService)
    {
        $this->fuzzyService = $fuzzyService;
    }

    public function index()
    {
        return view('fuzzy.index');
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'permintaan' => 'required|numeric|min:1000|max:1600',
            'persediaan' => 'required|numeric|min:600|max:900',
        ]);

        $permintaan = $request->input('permintaan');
        $persediaan = $request->input('persediaan');

        // Hitung prediksi menggunakan service
        $prediksiProduksi = $this->fuzzyService->calculate($permintaan, $persediaan);

        // Kembalikan ke view dengan hasil
        return view('fuzzy.index', [
            'permintaan' => $permintaan,
            'persediaan' => $persediaan,
            'prediksiProduksi' => round($prediksiProduksi)
        ]);
    }
}
