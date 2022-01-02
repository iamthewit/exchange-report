<?php


namespace ExchangeReport\ExchangeReport;

interface ExchangeTotalsReportWriteRepositoryInterface
{
    public function store(TotalsReport $report): void;
}