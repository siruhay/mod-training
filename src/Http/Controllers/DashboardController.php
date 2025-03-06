<?php

namespace Module\Training\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Module\Training\Models\TrainingEvent;
use Module\Training\Models\TrainingParticipant;
use Module\Training\Models\TrainingSubdistrict;

class DashboardController extends Controller
{
    /**
     * index function
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request): void
    {
        //
    }

    /**
     * mapReportData function
     *
     * @param [type] $type
     * @return array
     */
    public static function mapReportData(Request $request): array
    {
        switch ($request->type) {
            case 'participant':
                if ($request->subdistrict) {
                    $records = TrainingParticipant::with(['subdistrict', 'village'])->where('subdistrict_id', $request->subdistrict)->get();
                } else {
                    $records = TrainingParticipant::with(['subdistrict', 'village'])->get();
                }

                return [
                    'title'         => 'DAFTAR PESERTA',
                    'periode'       => now()->translatedFormat('d F Y'),
                    'subdistrict'   => optional(TrainingSubdistrict::find($request->subdistrict))->name,
                    'records'       => $records
                ];

            case 'event':
                if ($request->subdistrict) {
                    $records = TrainingEvent::with(['subdistrict', 'village'])->where('subdistrict_id', $request->subdistrict)->get();
                } else {
                    $records = TrainingEvent::with(['subdistrict', 'village'])->get();
                }

                return [
                    'title'         => 'DAFTAR PELATIHAN',
                    'periode'       => now()->translatedFormat('d F Y'),
                    'subdistrict'   => optional(TrainingSubdistrict::find($request->subdistrict))->name,
                    'records'       => $records
                ];

            default:
                return [];
        }
    }

    /**
     * report function
     *
     * @param Request $request
     * @return Illuminate\Contracts\View\View
     */
    public function report(Request $request): View | JsonResponse
    {
        if (!$request->has('type')) {
            return response()->json([
                'record' => [
                    'type' => null,
                    'subdistrict' => null
                ],

                'setups' => [
                    'combos' => [
                        'types' => [
                            ['title' => 'Daftar Peserta', 'value' => 'participant'],
                            ['title' => 'Daftar Pelatihan', 'value' => 'event'],
                        ],

                        'months' => [
                            ['title' => 'Januari', 'value' => 1],
                            ['title' => 'Februari', 'value' => 2],
                            ['title' => 'Maret', 'value' => 3],
                            ['title' => 'April', 'value' => 4],
                            ['title' => 'Mei', 'value' => 5],
                            ['title' => 'Juni', 'value' => 6],
                            ['title' => 'Juli', 'value' => 7],
                            ['title' => 'Agustus', 'value' => 8],
                            ['title' => 'September', 'value' => 9],
                            ['title' => 'Oktober', 'value' => 10],
                            ['title' => 'Nopember', 'value' => 11],
                            ['title' => 'Desember', 'value' => 12],
                        ],

                        'subdistricts' => TrainingSubdistrict::forCombo()
                    ]
                ]
            ]);
        }

        $reportData = static::mapReportData($request);

        return view('training::reports.' . $request->type, $reportData);
    }
}
