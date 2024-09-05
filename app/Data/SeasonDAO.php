<?php
declare(strict_types=1);

namespace Data;

use Data\DBConfig;
use PDO;
use PDOException;
use Exceptions\DatabaseErrorException;
use Entities\Season;

class SeasonDAO
{
    public function getAll(): array
    {
        try {
            // Open database connection
            $dbh = new PDO(
                DBConfig::$DB_CONNSTRING,
                DBConfig::$DB_USERNAME,
                DBConfig::$DB_PASSWORD
            );
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM seasons";

            // Prepare and execute the SQL query
            $stmt = $dbh->prepare($sql);
            $stmt->execute();

            // Fetch all results
            $resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Close dbh
            $dbh = null;

            $seasons = [];
            foreach ($resultSet as $row) {
                $season = new Season(
                    $row['id'],
                    $row['name'],
                    $row['start_date'],
                    $row['end_date']
                );
                $seasons[] = $season;
            }
            return $seasons;
        } catch (PDOException $e) {
            error_log("Error fetching seasons: " . $e->getMessage());
            throw new DatabaseErrorException('Error fetching seasons: ' . $e->getMessage());
        }
    }
}
