<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Services\HomepagePageService;

/**
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 *
 * Extend this class in any new controllers:
 *
 *     class Home extends BaseController
 *
 */
abstract class BaseController extends Controller
{
    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */

    protected $homepagePageService;

    public function initController(
        RequestInterface $request,
        ResponseInterface $response,
        LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);

        // 首頁頁面設定服務
        $this->homepagePageService = new HomepagePageService();

        /*
         * Navbar
         */
        $navbarPages = [];

        $pages = $this->homepagePageService
            ->getPagesByLocation('navbar');

        foreach ($pages as $page) {

            $state = $this->homepagePageService
                ->getPageState($page['page_key']);

            if ($state !== null) {
                $navbarPages[] = $state;
            }
        }

        /*
         * Sidebar
         */
        $sidebarPages = [];

        $pages = $this->homepagePageService
            ->getPagesByLocation('sidebar');

        foreach ($pages as $page) {

            $state = $this->homepagePageService
                ->getPageState($page['page_key']);

            if ($state !== null) {
                $sidebarPages[] = $state;
            }
        }

        /*
         * Sidebar 群組
         */
        $sidebarGroups = [];

        $groupKeys = [
            'admission',
            'related',
        ];

        foreach ($groupKeys as $groupKey) {

            $state = $this->homepagePageService
                ->getGroupState($groupKey);

            if ($state !== null) {
                $sidebarGroups[$groupKey] = $state;
            }
        }

        /*
         * 提供給所有 View 使用
         */
        service('renderer')->setVar(
            'navbarPages',
            $navbarPages
        );

        service('renderer')->setVar(
            'sidebarPages',
            $sidebarPages
        );

        service('renderer')->setVar(
            'sidebarGroups',
            $sidebarGroups
        );
    }

    protected function getHomepageNavigation(): array
    {
        $homepagePageService = new HomepagePageService();

        $navbarPages = [];
        $sidebarPages = [];
        $sidebarGroups = [];

        /*
         * Navbar
         */
        $navbarPagesData = $homepagePageService
            ->getPagesByLocation('navbar');

        foreach ($navbarPagesData as $page) {

            $state = $homepagePageService
                ->getPageState($page['page_key']);

            if ($state !== null) {
                $navbarPages[] = $state;
            }
        }

        /*
         * Sidebar
         */
        $sidebarPagesData = $homepagePageService
            ->getPagesByLocation('sidebar');

        foreach ($sidebarPagesData as $page) {

            $state = $homepagePageService
                ->getPageState($page['page_key']);

            if ($state !== null) {
                $sidebarPages[] = $state;
            }
        }

        /*
         * Sidebar 群組
         */
        $groupKeys = [
            'admission',
            'related',
        ];

        foreach ($groupKeys as $groupKey) {

            $state = $homepagePageService
                ->getGroupState($groupKey);

            if ($state !== null) {
                $sidebarGroups[$groupKey] = $state;
            }
        }

        return [
            'navbarPages'  => $navbarPages,
            'sidebarPages' => $sidebarPages,
            'sidebarGroups' => $sidebarGroups,
        ];
    }
}