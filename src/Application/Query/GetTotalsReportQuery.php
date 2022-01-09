<?php


namespace ExchangeReport\Application\Query;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * Class GetTotalsReportQuery
 * @package ExchangeReport\Application\Query
 */
class GetTotalsReportQuery
{
    private UuidInterface $reportId;

    /**
     * GetTotalsReportQuery constructor.
     */
    public function __construct()
    {
        $this->reportId = Uuid::fromString('f7119b91-1928-44ce-891b-f8c7b52026fc');
    }

    /**
     * @return UuidInterface
     */
    public function reportId(): UuidInterface
    {
        return $this->reportId;
    }
}