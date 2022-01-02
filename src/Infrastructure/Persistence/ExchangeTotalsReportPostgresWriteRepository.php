<?php

namespace ExchangeReport\Infrastructure\Persistence;

use ExchangeReport\ExchangeReport\ExchangeTotalsReportWriteRepositoryInterface;
use ExchangeReport\ExchangeReport\TotalsReport;
use PDO;

/**
 * Class MySqlExchangeReportWriteRepository
 * @package ExchangeReport\Infrastructure\Persistence
 */
class ExchangeTotalsReportPostgresWriteRepository implements ExchangeTotalsReportWriteRepositoryInterface
{
    private PDO $database;

    public function __construct(string $databaseDsn)
    {
        $this->database = new PDO($databaseDsn);
        // set error mode: https://phpdelusions.net/pdo#errors
        $this->database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function store(TotalsReport $report): void
    {
        $sql = <<<SQL
            INSERT INTO totals_report(id, trades_executed, traders_on_exchange, shares_on_exchange) 
            VALUES(:id, :trades_executed, :traders_on_exchange, :shares_on_exchange)
            ON CONFLICT(id)
            DO
            UPDATE SET 
                trades_executed=:trades_executed, 
                traders_on_exchange=:traders_on_exchange,
                shares_on_exchange=:shares_on_exchange
        SQL;

        $statement = $this->database->prepare($sql);
        $statement->execute([
            'id' => $report->id()->toString(),
            'trades_executed' => $report->tradesExecuted(),
            'traders_on_exchange' => $report->tradersOnExchange(),
            'shares_on_exchange' => $report->sharesOnExchange()
        ]);
    }
}