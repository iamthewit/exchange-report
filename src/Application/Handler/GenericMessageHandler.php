<?php

namespace ExchangeReport\Application\Handler;

use ExchangeReport\Application\Message\GenericMessage;
use ExchangeReport\ExchangeReport\ExchangeTotalsReportReadRepositoryInterface;
use ExchangeReport\ExchangeReport\ExchangeTotalsReportWriteRepositoryInterface;
use ExchangeReport\ExchangeReport\TotalsReport;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Class GenericMessageHandler
 * @package ExchangeReport\Application\Handler
 */
class GenericMessageHandler implements MessageHandlerInterface
{
    private ExchangeTotalsReportReadRepositoryInterface  $exchangeReportReadRepository;
    private ExchangeTotalsReportWriteRepositoryInterface $exchangeReportWriteRepository;

    /**
     * GenericMessageHandler constructor.
     *
     * @param ExchangeTotalsReportReadRepositoryInterface  $exchangeReportReadRepository
     * @param ExchangeTotalsReportWriteRepositoryInterface $exchangeReportWriteRepository
     */
    public function __construct(
        ExchangeTotalsReportReadRepositoryInterface $exchangeReportReadRepository,
        ExchangeTotalsReportWriteRepositoryInterface $exchangeReportWriteRepository
    ) {
        $this->exchangeReportWriteRepository = $exchangeReportWriteRepository;
        $this->exchangeReportReadRepository = $exchangeReportReadRepository;
    }

    public function __invoke(GenericMessage $genericMessage)
    {
        // hardcoded report id for now
        $reportId = Uuid::fromString('f7119b91-1928-44ce-891b-f8c7b52026fc');
        $report = $this->exchangeReportReadRepository->findById($reportId);

        // apply changes to domain model
        if ($genericMessage->type() === 'StockExchange\StockExchange\Event\Exchange\TradeExecuted') {
            $report->incrementTrades();
        }

        if ($genericMessage->type() === 'StockExchange\StockExchange\Event\Exchange\TraderAddedToExchange') {
            $report->incrementTraders();
        }

        if ($genericMessage->type() === 'StockExchange\StockExchange\Event\Exchange\ShareAddedToExchange') {
            $report->incrementShares();
        }

        // store the changes
        $this->exchangeReportWriteRepository->store($report);

        // TODO: update reports
            // total shares by symbol (FOO, BAR, etc) on exchange
    }
}