<?php


namespace ExchangeReport\ExchangeReport;

use Ramsey\Uuid\UuidInterface;

interface ExchangeReportReadRepositoryInterface
{
    public function findById(UuidInterface $id): Report;
}