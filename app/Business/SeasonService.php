<?php
declare(strict_types=1);

namespace Business;

use Data\SeasonDAO;
use Entities\Season;

class SeasonService
{
    public function getSeasons(): array
    {
        $seasonDAO = new SeasonDAO();
        return $seasonDAO->getAll();
    }

    public function getCurrentSeason(): ?Season
    {
        $seasonDAO = new SeasonDAO();
        $seasons = $seasonDAO->getAll();
        $currentDate = (new \DateTime())->format('Y-m-d H:i:s');
        foreach ($seasons as $season) {
            $startDate = $season->getStartDate();
            $endDate = $season->getEndDate();
            if ($currentDate >= $startDate && $currentDate <= $endDate) {
                return $season;
            }
        }
        // No season matches the current date, return empty season object;
        return null;
    }

    public function checkSeasonalProducts($seasonalProducts, $currentSeason): ?array
    {
        $filteredProducts = [];
        foreach ($seasonalProducts as $product) {
            if ($product->getSeasonId() == $currentSeason->getId()) {
                $filteredProducts[] = $product;
            }
        }
        return $filteredProducts;
    }
}
