<?php


namespace ExchangeReport\ExchangeReport;

use Exception;
use Ramsey\Uuid\UuidInterface;

interface ExchangeTotalsReportReadRepositoryInterface
{
    /**
     * @throws Exception
     */
    public function findById(UuidInterface $id): TotalsReport;
}