<?php


namespace ExchangeReport\Infrastructure\Persistence;

use ExchangeReport\ExchangeReport\Report;
use PDO;
use Ramsey\Uuid\UuidInterface;

/**
 * Class ExchangeReportPostgresReadRepository
 * @package ExchangeReport\Infrastructure\Persistence
 */
class ExchangeReportPostgresReadRepository implements \ExchangeReport\ExchangeReport\ExchangeReportReadRepositoryInterface
{
    private PDO $database;

    public function __construct(string $databaseDsn)
    {
        $this->database = new PDO($databaseDsn);
        // set error mode: https://phpdelusions.net/pdo#errors
        $this->database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function findById(UuidInterface $id): Report
    {
        $sql = <<<SQL
            SELECT * FROM reports
            WHERE id = :id 
        SQL;

        $statement = $this->database->prepare($sql);
        $statement->execute(['id' => $id->toString()]);

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            throw new \Exception('ruh roh');
        }

        return Report::restoreReportFromValues(
            $id,
            $result['trades_executed'],
        );
    }
}