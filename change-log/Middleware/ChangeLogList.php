<?php

namespace Zrcms\ChangeLog\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\Response\HtmlResponse;
use Zrcms\Acl\Api\IsAllowedRcmUser;
use Zrcms\ChangeLog\Api\ChangeLogEventToString;
use Zrcms\ChangeLog\Api\GetHumanReadableChangeLogByDateRange;
use Zrcms\Content\Api\GetChangeLogByDateRange;

/**
 * This outputs the change log as an HTML table.
 * WARNING: This may be REPLACED with a JSON API at some point.
 *
 * Class ChangeLogHtml
 * @package Zrcms\ChangeLog\Controller
 */
class ChangeLogList implements MiddlewareInterface
{
    protected $getHumanReadableChangeLogByDateRange;

    protected $defaultNumberOfDays = 30;

    public function __construct(
        GetHumanReadableChangeLogByDateRange $getHumanReadableChangeLogByDateRange
    ) {
        $this->getHumanReadableChangeLogByDateRange = $getHumanReadableChangeLogByDateRange;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $queryParams = $request->getQueryParams();
        $days = filter_var(
            isset($queryParams['days']) ? $queryParams['days'] : $this->defaultNumberOfDays, FILTER_VALIDATE_INT
        );

        if (!$days) {
            return new HtmlResponse('400 Bad Request - Invalid "days" param', 400);
        }

        $greaterThanYear = new \DateTime();
        $greaterThanYear = $greaterThanYear->sub(new \DateInterval('P' . $days . 'D'));
        $lessThanYear = new \DateTime();
        $humanReadableEvents = $this->getHumanReadableChangeLogByDateRange->__invoke($greaterThanYear, $lessThanYear);

        $description = 'Content change log events for ' . $days . ' days'
            . ' from ' . $greaterThanYear->format('c') . ' to ' . $lessThanYear->format('c');

        $contentType = isset($queryParams['content-type'])
            ? html_entity_decode($queryParams['content-type'])
            : 'application/json';

        switch ($contentType) {
            case 'application/json':
                return $this->makeJsonResponse($description, $humanReadableEvents);
                break;
            case 'text/html':
                return $this->makeHtmlResponse($description, $humanReadableEvents);
                break;
            case 'text/csv':
                return $this->makeCsvResponse($description, $humanReadableEvents);
                break;
            default:
                return new HtmlResponse('400 Bad Request - Invalid "content-type" param', 400);
        }
    }

    protected function makeCsvResponse($description, $humanReadableEvents)
    {
        $body = 'Date,' . $description;
        foreach ($humanReadableEvents as $changeLogItem) {
            $body .= "\n"
                . $changeLogItem['date']
                . ','
                . $changeLogItem['description'];
        }

        return new HtmlResponse($body, 200, ['content-type' => 'text/csv']);
    }

    protected function makeHtmlResponse($description, $humanReadableEvents)
    {
        $html = '<html class="container-fluid">';
        $html .= '<link href="/bower_components/bootstrap/dist/css/bootstrap.min.css" media="screen" rel="stylesheet" type="text/css">';
        $html .= '<a href="/zrcms/change-log?days=365&content-type=text%2Fcsv">Download CSV file for last 365 days</a>';
        $html .= '<table class="table table-sm">';
        $html .= '<tr><th>Date</th>';
        $html .= '<th>' . $description . '</th>';
        $html .= '</tr>';
        foreach ($humanReadableEvents as $changeLogItem) {
            $html .= '<tr><td class="text-nowrap">'
                . $changeLogItem['date']
                . '</td><td>'
                . $changeLogItem['description'];
            '</td></tr>';
        }
        $html .= '</table>';
        $html .= '</html>';

        return new HtmlResponse($html);
    }

    protected function makeJsonResponse($description, $humanReadableEvents)
    {
        return new Response\JsonResponse([
            'description' => $description,
            'events' => $humanReadableEvents
        ]);
    }
}
