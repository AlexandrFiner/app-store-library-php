<?php

namespace AppStoreLibrary\Enums\ConnectApi\Report\SalesAndTrends;

use Google\Service\Testing\AppBundle;

/**
 * These are the different product type identifiers used in your sales and financial reports for the App Store:
 * @link https://developer.apple.com/help/app-store-connect/reference/product-type-identifiers
 */
enum ProductTypeIdentifier: string
{
    /** iOS, iPadOS, visionOS, watchOS */
    case FreeOrPaidAppIosIpadOsVisionOsWatchOS = '1';

    /** iOS, iPadOS, visionOS app bundle */
    case AppBundleIosIpadOsVisionOs = '1-B';

    /** Mac app bundle */
    case AppBundleMac = 'F1-B';

    /** Custom iOS app */
    case PaidAppIos = '1E';

    /** Custom iPadOS app */
    case PaidAppIpadOs = '1EP';

    /** Custom universal app */
    case PaidAppUniversal = '1EU';

    /** Universal app, excluding tvOS */
    case FreeOrPaidAppUniversalExcludingTvOs = '1F';

    /** iPad apps */
    case FreeOrPaidAppIpad = '1T';

    /** App update (iOS, tvOS, visionOS, watchOS) */
    case ReDownloadIosTvOsVisionOsWatchOs = '3';

    /** Universal app, excluding tvOS */
    case ReDownloadUniversalExcludingTvOs = '3F';

    /** App update (iOS, tvOS, visionOS, watchOS) */
    case UpdateIosTvOsVisionOsWatchOs = '7';

    /** Universal app, excluding tvOS */
    case UpdateUniversalExcludingTvOs = '7F';

    /** App update (iPadOS, visionOS) */
    case UpdateIpadOsVisionOs = '7T';

    /** Mac */
    case FreeOrPaidAppMac = 'F1';

    /** App update (Mac) */
    case UpdateMac = 'F7';

    /** Mac **/
    case InAppPurchaseMac = 'FI1';

    /** In-app purchase (iOS, iPadOS, visionOS) **/
    case InAppPurchaseIosIpadOsVisionOs = 'IA1';

    /** In-app purchase (Mac) **/
    case InAppPurchaseMacM = 'IA1-M';

    /** Non consumable in-app purchase **/
    case RestoredInAppPurchase = 'IA3';

    /** Non-renewing subscription (iOS, iPadOS, visionOS) */
    case InAppPurchaseNonRenewingSubscription = 'IA9';

    /** Subscription (Mac) */
    case InAppPurchaseSubscriptionMac = 'IA9-M';

    /** Auto-renewable subscription (iOS, iPadOS, visionOS) */
    case InAppPurchaseAuthRenewableSubscriptionIosIpadOsVisionOs = 'IAY';

    /** Auto-renewable subscription (Mac) */
    case InAppPurchaseAutoRenewableSubscriptionMac = 'IAY-M';

    public function getType(): ProductType
    {
        return match ($this) {
            self::FreeOrPaidAppIosIpadOsVisionOsWatchOS,
            self::FreeOrPaidAppUniversalExcludingTvOs,
            self::FreeOrPaidAppIpad,
            self::FreeOrPaidAppMac => ProductType::FreeOrPaidApp,
            self::AppBundleIosIpadOsVisionOs,
            self::AppBundleMac => ProductType::AppBundle,
            self::PaidAppIos,
            self::PaidAppIpadOs,
            self::PaidAppUniversal => ProductType::PaidApp,
            self::ReDownloadIosTvOsVisionOsWatchOs,
            self::ReDownloadUniversalExcludingTvOs => ProductType::ReDownload,
            self::UpdateIosTvOsVisionOsWatchOs,
            self::UpdateUniversalExcludingTvOs,
            self::UpdateIpadOsVisionOs,
            self::UpdateMac => ProductType::Update,
            self::InAppPurchaseMac,
            self::InAppPurchaseIosIpadOsVisionOs,
            self::InAppPurchaseMacM,
            self::InAppPurchaseNonRenewingSubscription,
            self::InAppPurchaseSubscriptionMac,
            self::InAppPurchaseAuthRenewableSubscriptionIosIpadOsVisionOs,
            self::InAppPurchaseAutoRenewableSubscriptionMac => ProductType::InAppPurchase,
            self::RestoredInAppPurchase => ProductType::RestoredInAppPurchase,
        };
    }
}
