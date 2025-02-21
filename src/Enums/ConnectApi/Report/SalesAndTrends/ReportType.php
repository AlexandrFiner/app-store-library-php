<?php

namespace AppStoreLibrary\Enums\ConnectApi\Report\SalesAndTrends;

use AppStoreLibrary\Enums\EnumToArray;

/**
 * @link https://developer.apple.com/documentation/appstoreconnectapi/get-v1-salesreports
 */
enum ReportType: string
{
    use EnumToArray;

    /**
     * Aggregated sales and download data for your apps and In-App Purchases
     * @link https://developer.apple.com/help/app-store-connect/reference/summary-sales-report
     */
    case Sales = 'SALES';
    /** Aggregated data for your apps you’ve made available for pre-order, including the number of units ordered and canceled by customers
     * @link https://developer.apple.com/help/app-store-connect/reference/pre-order-report
     */
    case PreOrder = 'PRE_ORDER';
    /**
     * Transaction-level data for Magazines & Newspapers apps
     * @link https://developer.apple.com/help/app-store-connect/reference/magazines-and-newspapers-report
     */
    case Newsstand = 'NEWSSTAND';
    /**
     * Total number of Active Subscriptions, Subscriptions with Introductory Prices, and Marketing Opt-Ins for your auto-renewable subscriptions
     * @link https://developer.apple.com/help/app-store-connect/reference/subscription-report
     */
    case Subscription = 'SUBSCRIPTION';
    /**
     * Aggregated data about subscriber activity, including upgrades, renewals, and introductory price conversions
     * @link https://developer.apple.com/help/app-store-connect/reference/subscription-event-report
     */
    case SubscriptionEvent = 'SUBSCRIPTION_EVENT';
    /**
     * Transaction-level data about subscriber activity using randomly generated Subscriber IDs
     * @link https://developer.apple.com/help/app-store-connect/reference/subscriber-report
     */
    case Subscriber = 'SUBSCRIBER';
    /**
     * Details on the total number of subscription offer code redemptions, including the dates redemptions occurred and from which country or region
     * @link https://developer.apple.com/help/app-store-connect/reference/subscription-offer-redemption-report
     */
    case SubscriptionOfferCodeRedemption = 'SUBSCRIPTION_OFFER_CODE_REDEMPTION';
    /**
     * @link https://developer.apple.com/help/app-store-connect/distributing-apps-in-the-european-union/core-technology-fee-report-fields/
     */
    case Installs = 'INSTALLS';
    /**
     * @link https://developer.apple.com/help/app-store-connect/distributing-apps-in-the-european-union/core-technology-fee-report-fields/
     */
    case FirstAnnual = 'FIRST_ANNUAL';
    /**
     * The total number of churned subscriptions aggregated by paid tenure, churned duration, and time since last win-back.
     * Excludes subscriptions that have been churned for more than two years
     * @link https://developer.apple.com/help/app-store-connect/reference/win-back-eligibility-report
     */
    case WinBackEligibility = 'WIN_BACK_ELIGIBILITY';
}