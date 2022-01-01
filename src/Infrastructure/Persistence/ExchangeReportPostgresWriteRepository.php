<?php


namespace ExchangeReport\Infrastructure\Persistence;

use ExchangeReport\ExchangeReport\ExchangeReportWriteRepositoryInterface;
use ExchangeReport\ExchangeReport\Report;
use PDO;

/**
 * Class MySqlExchangeReportWriteRepository
 * @package ExchangeReport\Infrastructure\Persistence
 */
class ExchangeReportPostgresWriteRepository implements ExchangeReportWriteRepositoryInterface
{
    private PDO $database;

    public function __construct(string $databaseDsn)
    {
        $this->database = new PDO($databaseDsn);
        // set error mode: https://phpdelusions.net/pdo#errors
        $this->database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function store(Report $report): void
    {
        $sql = <<<SQL
            INSERT INTO reports(id, trades_executed) 
            VALUES(:id, :trades_executed)
            ON CONFLICT(id)
            DO
            UPDATE SET trades_executed=:trades_executed 
        SQL;

        $statement = $this->database->prepare($sql);
        $statement->execute([
            'id' => $report->id()->toString(),
            'trades_executed' => $report->tradesExecuted(),
        ]);
    }
}