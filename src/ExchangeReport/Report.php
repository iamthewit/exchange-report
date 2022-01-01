<?php


namespace ExchangeReport\ExchangeReport;

use JetBrains\PhpStorm\ArrayShape;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * Class Report
 * @package ExchangeReport\ExchangeReport
 */
class Report implements \JsonSerializable
{
    private UuidInterface $id;
    private int $tradesExecuted;

    private function __construct()
    {
    }

    public function id(): UuidInterface
    {
        return $this->id;
    }

    public function tradesExecuted(): int
    {
        return $this->tradesExecuted;
    }

    public static function create(UuidInterface $id): Report
    {
        $report = new self();
        $report->id = $id;
        $report->tradesExecuted = 0;

        return $report;
    }

    public static function restoreReportFromValues(UuidInterface $id, int $tradesExecuted): Report
    {
        $report = new self();
        $report->id = $id;
        $report->tradesExecuted = $tradesExecuted;

        return $report;
    }

    public function incrementTrades()
    {
        $this->tradesExecuted++;
    }

    #[ArrayShape(['id' => "string", 'tradesExecuted' => "int"])]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id()->toString(),
            'tradesExecuted' => $this->tradesExecuted()
        ];
    }
}