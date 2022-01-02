<?php

namespace ExchangeReport\Infrastructure\Persistence;

use ExchangeReport\ExchangeReport\TotalsReport;
use PDO;
use Ramsey\Uuid\UuidInterface;

/**
 * Class ExchangeReportPostgresReadRepository
 * @package ExchangeReport\Infrastructure\Persistence
 */
class ExchangeTotalsReportPostgresReadRepository implements \ExchangeReport\ExchangeReport\ExchangeTotalsReportReadRepositoryInterface
{
    private PDO $database;

    public function __construct(string $databaseDsn)
    {
        $this->database = new PDO($databaseDsn);
        // set error mode: https://phpdelusions.net/pdo#errors
        $this->database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function findById(UuidInterface $id): TotalsReport
    {
        $sql = <<<SQL
            SELECT * FROM totals_report
            WHERE id = :id 
        SQL;

        $statement = $this->database->prepare($sql);
        $statement->execute(['id' => $id->toString()]);

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            throw new \Exception('ruh roh');
        }

        return TotalsReport::restoreReportFromValues(
            $id,
            $result['trades_executed'],
            $result['traders_on_exchange'],
            $result['shares_on_exchange']
        );
    }
}