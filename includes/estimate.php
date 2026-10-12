<?php
/*
 * estimate.php
 * computes the preliminary quote. The JS (home.js) does the same formula
 * so the user sees it instantly, but we compute it again here before saving
 * para hindi ma-edit ng user yung price sa inspect element.
 */
require_once __DIR__ . '/config.php';

function calculateEstimate(string $category, string $type, float $widthCm, float $heightCm, int $qty, string $glass, string $finish): array|false
{
    if (!isset(PRICE_LIST[$category]['types'][$type])) {
        return false;
    }

    $rate = PRICE_LIST[$category]['types'][$type];

    // cm -> square meters. minimum of 0.5 sqm per unit (small items still have cutting/labor cost)
    $area = ($widthCm * $heightCm) / 10000;
    if ($area < 0.5) {
        $area = 0.5;
    }

    // blinds and shutters don't have glass
    $glassMult = isset(GLASS_OPTIONS[$glass]) ? GLASS_OPTIONS[$glass] : 1;
    $finishMult = isset(FINISH_OPTIONS[$finish]) ? FINISH_OPTIONS[$finish] : 1;

    $unitPrice = $rate * $area * $glassMult * $finishMult;
    $total = $unitPrice * $qty;

    return [
        'area'      => round($area, 2),
        'unit'      => round($unitPrice, 2),
        'total'     => round($total, 2),
        // +/- 10% kasi preliminary lang
        'low'       => round($total * 0.9, -2),
        'high'      => round($total * 1.1, -2),
    ];
}
