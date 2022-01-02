<?php


namespace ExchangeReport\ExchangeReport;

use JetBrains\PhpStorm\ArrayShape;
use Ramsey\Uuid\UuidInterface;

/**
 * Class Report
 * @package ExchangeReport\ExchangeReport
 */
class TotalsReport implements \JsonSerializable
{
    private UuidInterface $id;
    private int $tradesExecuted;
    private int $tradersOnExchange;
    private int $sharesOnExchange;

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

    public function tradersOnExchange(): int
    {
        return $this->tradersOnExchange;
    }

    public function sharesOnExchange(): int
    {
        return $this->sharesOnExchange;
    }

    public static function create(UuidInterface $id): TotalsReport
    {
        $totalsReport = new self();
        $totalsReport->id = $id;
        $totalsReport->tradesExecuted = 0;
        $totalsReport->tradersOnExchange = 0;
        $totalsReport->sharesOnExchange = 0;

        return $totalsReport;
    }

    public static function restoreReportFromValues(
        UuidInterface $id,
        int $tradesExecuted,
        int $tradersOnExchange,
        int $sharesOnExchange
    ): TotalsReport
    {
        $totalsReport = new self();
        $totalsReport->id = $id;
        $totalsReport->tradesExecuted = $tradesExecuted;
        $totalsReport->tradersOnExchange = $tradersOnExchange;
        $totalsReport->sharesOnExchange = $sharesOnExchange;

        return $totalsReport;
    }

    public function incrementTrades()
    {
        $this->tradesExecuted++;
    }

    public function incrementTraders()
    {
        $this->tradersOnExchange++;
    }

    public function incrementShares()
    {
        $this->sharesOnExchange++;
    }

    #[ArrayShape(['id' => "string", 'tradesExecuted' => "int", 'tradersOnExchange' => "int", 'sharesOnExhange' => "int"])]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id()->toString(),
            'tradesExecuted' => $this->tradesExecuted(),
            'tradersOnExchange' => $this->tradersOnExchange(),
            'sharesOnExhange' => $this->sharesOnExchange()
        ];
    }
}