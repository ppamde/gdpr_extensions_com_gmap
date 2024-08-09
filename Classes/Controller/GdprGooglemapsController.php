<?php

declare(strict_types=1);

namespace GdprExtensionsCom\GdprExtensionsComGmap\Controller;


use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * This file is part of the "gdpr-extensions-com-googlemaps" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2023
 */

/**
 * gdprgooglemapsController
 */
class GdprGooglemapsController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{


    /**
     * gdprManagerRepository
     *
     * @var \GdprExtensionsCom\GdprExtensionsComGmap\Domain\Repository\GdprManagerRepository
     */

    protected $gdprManagerRepository = null;

    /**
     * ContentObject
     *
     * @var ContentObject
     */
    protected $contentObject = null;

    /**
     * @param \GdprExtensionsCom\GdprExtensionsComGmap\Domain\Repository\GdprManagerRepository $gdprManagerRepository
     */
    public function injectGdprManagerRepository(\GdprExtensionsCom\GdprExtensionsComGmap\Domain\Repository\GdprManagerRepository $gdprManagerRepository)
    {
        $this->gdprManagerRepository = $gdprManagerRepository;
    }

    /**
     * action index
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function indexAction(): \Psr\Http\Message\ResponseInterface
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_gdprextensionscomyoutube_domain_model_gdprmanager');
        $gdprSettingGooglemaps = $queryBuilder
            ->select('*')
            ->from('tx_gdprextensionscomyoutube_domain_model_gdprmanager')->where(
                $queryBuilder->expr()->like('extension_title', $queryBuilder->createNamedParameter('%' . (string)'googlemaps' . '%'))
            );
        $settings = $gdprSettingGooglemaps->fetchAssociative();

        $gdprManagers = $this->gdprManagerRepository->findAll();
        $mapLocations = [];
        foreach ($gdprManagers as $gdprManager) {
            if ($gdprManager->getExtensionKey() == "gdpr_extensions_com_gmap") {
                foreach ($gdprManager->getLocations() as $key => $location) {
//                    dd($location);
                    $tempArray = [
                        'title' => $location->getTitle(),
                        'address' => $location->getAddress(),
                        'lat' => $location->getLat(),
                        'long' => $location->getLon(),
                    ];
//                    array_push($tempArray,$location->getTitle(),$location->getAddress(),$location->getLat(),$location->getLon());
                    $mapLocations[] = $tempArray;
                }
                $this->view->assign('GooglemapsApiKey', $gdprManager->getMapApi());
            }
        }


        $this->view->assign('LatLongData', json_encode($mapLocations));
        $this->view->assign('GooglemapsData', $this->contentObject->data);
        $this->view->assign('rootPid', $this->request->getAttribute('site')->getRootPageId());
        $this->view->assign('GooglemapsSettings', $settings);
        return $this->htmlResponse();
    }

    /**
     * Action initialize
     */
    protected function initializeAction(): void
    {
        $this->contentObject = $this->request->getAttribute('currentContentObject');
        // intialize the content object
    }
}
