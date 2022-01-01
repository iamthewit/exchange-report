<?php

namespace ExchangeReport\Application\Handler;

use ExchangeReport\Application\Message\GenericMessage;
use ExchangeReport\ExchangeReport\ExchangeReportReadRepositoryInterface;
use ExchangeReport\ExchangeReport\ExchangeReportWriteRepositoryInterface;
use ExchangeReport\ExchangeReport\Report;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Class GenericMessageHandler
 * @package ExchangeReport\Application\Handler
 */
class GenericMessageHandler implements MessageHandlerInterface
{
    private ExchangeReportReadRepositoryInterface $exchangeReportReadRepository;
    private ExchangeReportWriteRepositoryInterface $exchangeReportWriteRepository;

    /**
     * GenericMessageHandler constructor.
     *
     * @param ExchangeReportReadRepositoryInterface  $exchangeReportReadRepository
     * @param ExchangeReportWriteRepositoryInterface $exchangeReportWriteRepository
     */
    public function __construct(
        ExchangeReportReadRepositoryInterface $exchangeReportReadRepository,
        ExchangeReportWriteRepositoryInterface $exchangeReportWriteRepository
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

        // store the changes
        $this->exchangeReportWriteRepository->store($report);

        // TODO: update reports
            // total trades executed
            // total traders on exchange
            // total shares on exchange
            // total shares by symbol (FOO, BAR, etc) on exchange
    }
}