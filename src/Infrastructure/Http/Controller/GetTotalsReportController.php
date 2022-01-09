<?php


namespace ExchangeReport\Infrastructure\Http\Controller;

use ExchangeReport\Application\MessageBus\QueryHandlerBus;
use ExchangeReport\Application\Query\GetTotalsReportQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GetTotalsReportController
 * @package ExchangeReport\Infrastructure\Http\Controller
 */
class GetTotalsReportController
{
    private QueryHandlerBus $queryHandlerBus;

    /**
     * GetTotalsReportController constructor.
     *
     * @param QueryHandlerBus $queryHandlerBus
     */
    public function __construct(QueryHandlerBus $queryHandlerBus)
    {
        $this->queryHandlerBus = $queryHandlerBus;
    }

    /**
     * @Route("/report/totals", name="report_totals", methods={"GET"})
     */
    public function __invoke(): JsonResponse
    {
        $query = new GetTotalsReportQuery();
        $report = $this->queryHandlerBus->query($query);

        return new JsonResponse($report);
    }
}