<?php


namespace ExchangeReport\ExchangeReport;

interface ExchangeReportWriteRepositoryInterface
{
    public function store(Report $report): void;
}