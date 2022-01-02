<?php


namespace ExchangeReport\ExchangeReport;

use Ramsey\Uuid\UuidInterface;

interface ExchangeTotalsReportReadRepositoryInterface
{
    public function findById(UuidInterface $id): TotalsReport;
}