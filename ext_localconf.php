<?php
defined('TYPO3') || die();

(static function() {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'GdprExtensionsComGmap',
        'gdprgooglemaps',
        [
            \GdprExtensionsCom\GdprExtensionsComGmap\Controller\GdprGooglemapsController::class => 'index'
        ],
        // non-cacheable actions
        [
            \GdprExtensionsCom\GdprExtensionsComGmap\Controller\GdprGooglemapsController::class => '',
            \GdprExtensionsCom\GdprExtensionsComGmap\Controller\GdprManagerController::class => 'create, update, delete'
        ],
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
    );

    // register plugin for cookie widget
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'GdprExtensionsComGmap',
        'gdprcookiewidget',
        [
            \GdprExtensionsCom\GdprExtensionsComGmap\Controller\GdprCookieWidgetController::class => 'index'
        ],
        // non-cacheable actions
        [],
    );

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        'mod {
            wizards.newContentElement.wizardItems.plugins {
                elements {
                    gdprcookiewidget {
                        iconIdentifier = gdpr_extensions_com_gmap-plugin-gdprgooglemaps
                        title = cookie
                        description = LLL:EXT:gdpr_extensions_com_gmap/Resources/Private/Language/locallang_db.xlf:tx_gdpr_extensions_com_gmap_gdprgooglemaps.description
                        tt_content_defValues {
                            CType = list
                            list_type = gdprextensionscomgmap_gdprcookiewidget
                        }
                    }
                }
                show = *
            }
       }'
    );

    // wizards
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        'mod.wizards.newContentElement.wizardItems {
               gdpr.header = LLL:EXT:gdpr_extensions_com_gmap/Resources/Private/Language/locallang_db.xlf:tx_gdpr_extensions_com_gmap.tab.name
        }'
    );

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        'mod {
            wizards.newContentElement.wizardItems.gdpr {
                elements {
                    gdprgooglemaps {
                        iconIdentifier = content_element_icon
                        title = LLL:EXT:gdpr_extensions_com_gmap/Resources/Private/Language/locallang_db.xlf:tx_gdpr_extensions_com_gmap_gdprgooglemaps.name
                        description = LLL:EXT:gdpr_extensions_com_gmap/Resources/Private/Language/locallang_db.xlf:tx_gdpr_extensions_com_gmap_gdprgooglemaps.description
                        tt_content_defValues {
                            CType = gdprextensionscomgmap_gdprgooglemaps
                        }
                    }
                }
                show = *
            }
       }'
    );
})();
