<?php


namespace ExchangeReport\Application\Handler;

use ExchangeReport\Application\Query\GetTotalsReportQuery;
use ExchangeReport\ExchangeReport\ExchangeTotalsReportReadRepositoryInterface;
use ExchangeReport\ExchangeReport\TotalsReport;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Class GetTotalsReportQueryHandler
 * @package ExchangeReport\Application\Handler
 */
class GetTotalsReportQueryHandler implements MessageHandlerInterface
{
    private ExchangeTotalsReportReadRepositoryInterface  $exchangeReportReadRepository;

    /**
     * GenericMessageHandler constructor.
     *
     * @param ExchangeTotalsReportReadRepositoryInterface  $exchangeReportReadRepository
     */
    public function __construct(
        ExchangeTotalsReportReadRepositoryInterface $exchangeReportReadRepository,
    ) {
        $this->exchangeReportReadRepository = $exchangeReportReadRepository;
    }

    public function __invoke(GetTotalsReportQuery $getTotalsReportQuery): TotalsReport
    {
        $report = $this->exchangeReportReadRepository->findById($getTotalsReportQuery->reportId());

        return $report;
    }
}