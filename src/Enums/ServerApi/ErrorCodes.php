<?php

namespace AppStoreLibrary\Enums\ServerApi;

/**
 * @link https://developer.apple.com/documentation/appstoreserverapi/error_codes
 */
enum ErrorCodes: int
{
    // Errors
    /** An error that indicates the App Store account wasn’t found. */
    case AccountNotFoundError = 4040001;
    /** An error that indicates the app wasn’t found. */
    case AppNotFoundError = 4040003;
    /** An error that indicates a subscription isn't directly eligible for a renewal date extension because the customer obtained it through Family Sharing. */
    case FamilySharedSubscriptionExtensionIneligibleError = 4030007;
    /** An error that indicates a general internal error. */
    case GeneralInternalError = 5000000;
    /** An error that indicates an invalid request. */
    case GeneralBadRequestError = 4000000;
    /** An error that indicates an invalid app identifier. */
    case InvalidAppIdentifierError = 4000002;
    /** An error that indicates a required storefront country code is empty. */
    case InvalidEmptyStorefrontCountryCodeListError = 4000027;
    /** An error that indicates an invalid extend-by-days value. */
    case InvalidExtendByDaysError = 4000009;
    /** An error that indicates an invalid reason code. */
    case InvalidExtendReasonCodeError = 4000010;
    /** An error that indicates an invalid original transaction identifier. */
    case InvalidOriginalTransactionIdError = 4000008;
    /** An error that indicates an invalid refund preference code. */
    case InvalidRefundPreferenceError = 4000044;
    /** An error that indicates an invalid request identifier. */
    case InvalidRequestIdentifierError = 4000011;
    /** An error that indicates an invalid request revision. */
    case InvalidRequestRevisionError = 4000005;
    /** An error that indicates the revoked parameter contains an invalid value. */
    case InvalidRevokedError = 4000030;
    /** An error that indicates the status parameter is invalid. */
    case InvalidStatusError = 4000031;
    /** An error that indicates a storefront code is invalid. */
    case InvalidStorefrontCountryCodeError = 4000028;
    /** An error that indicates an invalid transaction identifier. */
    case InvalidTransactionIdError = 4000006;
    /** An error that indicates an original transaction identifier wasn’t found. */
    case OriginalTransactionIdNotFoundError = 4040005;
    /** An error that indicates the request exceeded the rate limit. */
    case RateLimitExceededError = 4290000;
    /** An error that indicates the server didn’t find a subscription-renewal-date extension request for the request identifier and product identifier you provided. */
    case StatusRequestNotFoundError = 4040009;
    /** An error that indicates the subscription doesn’t qualify for a renewal-date extension due to its subscription state. */
    case SubscriptionExtensionIneligibleError = 4030004;
    /** An error that indicates the subscription doesn’t qualify for a renewal-date extension because it has already received the maximum extensions. */
    case SubscriptionMaxExtensionError = 4030005;
    /** An error that indicates a transaction identifier wasn’t found. */
    case TransactionIdNotFoundError = 4040010;

    // Errors to retry
    /** An error response that indicates the App Store account wasn’t found, but you can try again. */
    case AccountNotFoundRetryableError = 4040002;
    /** An error response that indicates the app wasn’t found, but you can try again. */
    case AppNotFoundRetryableError = 4040004;
    /** An error response that indicates an unknown error occurred, but you can try again. */
    case GeneralInternalRetryableError = 5000001;
    /** An error response that indicates the original transaction identifier wasn’t found, but you can try again. */
    case OriginalTransactionIdNotFoundRetryableError = 4040006;

    // Consumption request errors
    /** An error that indicates the value of the account tenure field is invalid. */
    case InvalidAccountTenureError = 4000032;
    /** An error that indicates the value of the app account token field is invalid. */
    case InvalidAppAccountTokenError = 4000033;
    /** An error that indicates the value of the consumption status field is invalid. */
    case InvalidConsumptionStatusError = 4000034;
    /** An error that indicates the customer consented field is invalid or doesn’t indicate that the customer consented. */
    case InvalidCustomerConsentedError = 4000035;
    /** An error that indicates the value in the delivery status field is invalid. */
    case InvalidDeliveryStatusError = 4000036;
    /** An error that indicates the value in the delivery status field is invalid. */
    case InvalidLifetimeDollarsPurchasedError = 4000037;
    /** An error that indicates the value in the lifetime dollars refunded field is invalid. */
    case InvalidLifetimeDollarsRefundedError = 4000038;
    /** An error that indicates the value in the platform field is invalid. */
    case InvalidPlatformError = 4000039;
    /** An error that indicates the value in the playtime field is invalid. */
    case InvalidPlayTimeError = 4000040;
    /** An error that indicates the value in the sample content provided field is invalid. */
    case InvalidSampleContentProvidedError = 4000041;
    /** An error that indicates the transaction identifier represents an unsupported In-App Purchase type. */
    case InvalidTransactionTypeNotSupportedError = 4000047;
    /** An error that indicates the value in the user status field is invalid. */
    case InvalidUserStatusError = 4000042;

    // Notification test and history errors
    case InvalidEndDateError = 4000016;
    /** An error that indicates the notification type or subtype is invalid. */
    case InvalidNotificationTypeError = 4000018;
    /** An error that indicates the pagination token is invalid. */
    case InvalidPaginationTokenError = 4000014;
    /** An error that indicates the start date is invalid. */
    case InvalidStartDateError = 4000015;
    /** An error that indicates the test notification token is invalid. */
    case InvalidTestNotificationTokenError = 4000020;
    /** An error that indicates an invalid in-app ownership type parameter. */
    case InvalidInAppOwnershipTypeError = 4000026;
    /** An error that indicates the product ID parameter is invalid. */
    case InvalidProductIdError = 4000023;
    /** An error that indicates the product type parameter is invalid. */
    case InvalidProductTypeError = 4000022;
    /** An error that indicates the sort parameter is invalid. */
    case InvalidSortError = 4000021;
    /** An error that indicates the subscription group identifier is invalid. */
    case InvalidSubscriptionGroupIdentifierError = 4000024;
    /** An error that indicates the request is invalid because it has too many applied constraints. */
    case MultipleFiltersSuppliedError = 4000019;
    /** An error that indicates the pagination token expired. */
    case PaginationTokenExpiredError = 4000017;
    /** An error that indicates the App Store server couldn’t find a notifications URL for your app in the environment. */
    case ServerNotificationURLNotFoundError = 4040007;
    /** An error that indicates the end date precedes the start date, or the two dates are equal. */
    case StartDateAfterEndDateError = 4000013;
    /** An error that indicates the start date is earlier than the earliest allowed date. */
    case StartDateTooFarInPastError = 4000012;
    /** An error that indicates the test notification token is expired or the test notification status isn’t available. */
    case TestNotificationNotFoundError = 4040008;

    public const RETRYABLE_ERRORS = [
        self::AccountNotFoundRetryableError,
        self::AppNotFoundRetryableError,
        self::GeneralInternalRetryableError,
        self::OriginalTransactionIdNotFoundRetryableError,
    ];

    public function isRetryableError(): bool
    {
        return in_array($this, self::RETRYABLE_ERRORS);
    }

    public function getMessage(): string
    {
        return match ($this) {
            self::AccountNotFoundError => 'Account not found.',
            self::AppNotFoundError => 'App not found.',
            self::FamilySharedSubscriptionExtensionIneligibleError => 'Subscriptions that users obtain through Family Sharing can\'t get a renewal date extension directly.',
            self::GeneralInternalError => 'An unknown error occurred.',
            self::GeneralBadRequestError => 'Bad request.',
            self::InvalidAppIdentifierError => 'Invalid request app identifier.',
            self::InvalidEmptyStorefrontCountryCodeListError => 'Invalid request. If provided, the list of storefront country codes must not be empty.',
            self::InvalidExtendByDaysError => 'Invalid extend by days value.',
            self::InvalidExtendReasonCodeError => 'Invalid extend reason code.',
            self::InvalidOriginalTransactionIdError => 'Invalid original transaction id.',
            self::InvalidRefundPreferenceError => 'Invalid request. The refund preference field is invalid.',
            self::InvalidRequestIdentifierError => 'Invalid request identifier.',
            self::InvalidRequestRevisionError => 'Invalid request revision.',
            self::InvalidRevokedError => 'Invalid request. The revoked parameter is invalid.',
            self::InvalidStatusError => 'Invalid request. The status parameter is invalid.',
            self::InvalidStorefrontCountryCodeError => 'Invalid request. A storefront country code was invalid.',
            self::InvalidTransactionIdError => 'Invalid transaction id.',
            self::OriginalTransactionIdNotFoundError => 'Original transaction id not found.',
            self::RateLimitExceededError => 'Rate limit exceeded.',
            self::StatusRequestNotFoundError => 'The server didn\'t find a subscription-renewal-date extension request for this requestIdentifier and productId combination.',
            self::SubscriptionExtensionIneligibleError => 'Forbidden - subscription state ineligible for extension.',
            self::SubscriptionMaxExtensionError => 'Forbidden - subscription has reached maximum extension count.',
            self::TransactionIdNotFoundError => 'Transaction id not found.',
            self::AccountNotFoundRetryableError => 'Account not found. Please try again.',
            self::AppNotFoundRetryableError => 'App not found. Please try again.',
            self::GeneralInternalRetryableError => 'An unknown error occurred. Please try again.',
            self::OriginalTransactionIdNotFoundRetryableError => 'Original transaction id not found. Please try again.',
            self::InvalidAccountTenureError => 'Invalid request. The account tenure field is invalid.',
            self::InvalidAppAccountTokenError => 'Invalid request. The app account token field must contain a valid UUID or an empty string.',
            self::InvalidConsumptionStatusError => 'Invalid request. The consumption status field is invalid.',
            self::InvalidCustomerConsentedError => 'Invalid request. The customer consented field is required and must indicate the customer consented.',
            self::InvalidDeliveryStatusError => 'Invalid request. The delivery status field is invalid.',
            self::InvalidLifetimeDollarsPurchasedError => 'Invalid request. The lifetime dollars purchased field is invalid.',
            self::InvalidLifetimeDollarsRefundedError => 'Invalid request. The lifetime dollars refunded field is invalid.',
            self::InvalidPlatformError => 'Invalid request. The platform field is invalid.',
            self::InvalidPlayTimeError => 'Invalid request. The playtime field is invalid.',
            self::InvalidSampleContentProvidedError => 'Invalid request. The sample content provided field is invalid.',
            self::InvalidTransactionTypeNotSupportedError => 'Invalid request. The transaction id doesn\'t represent a supported in-app purchase type.',
            self::InvalidUserStatusError => 'Invalid request. The user status field is invalid.',
            self::InvalidEndDateError => 'Invalid request. The end date is not a timestamp value represented in milliseconds.',
            self::InvalidNotificationTypeError => 'Invalid request. The notification type or subtype is invalid.',
            self::InvalidPaginationTokenError => 'Invalid request. The pagination token is invalid.',
            self::InvalidStartDateError => 'Invalid request. The start date is not a timestamp value represented in milliseconds.',
            self::InvalidTestNotificationTokenError => 'Invalid request. The test notification token is invalid.',
            self::InvalidInAppOwnershipTypeError => 'Invalid request. The in-app ownership type parameter is invalid.',
            self::InvalidProductIdError => 'Invalid request. The product id parameter is invalid.',
            self::InvalidProductTypeError => 'Invalid request. The product type parameter is invalid.',
            self::InvalidSortError => 'Invalid request. The sort parameter is invalid.',
            self::InvalidSubscriptionGroupIdentifierError => 'Invalid request. The subscription group identifier parameter is invalid.',
            self::MultipleFiltersSuppliedError => 'Invalid request. Supply either a transaction id or a notification type, but not both.',
            self::PaginationTokenExpiredError => 'Invalid request. The pagination token is expired.',
            self::ServerNotificationURLNotFoundError => 'No App Store Server Notification URL found for provided app. Check that a URL is configured in App Store Connect for this environment.',
            self::StartDateAfterEndDateError => 'Invalid request. The end date precedes the start date or the dates are the same.',
            self::StartDateTooFarInPastError => 'Invalid request. The start date is earlier than the allowed start date.',
            self::TestNotificationNotFoundError => 'Either the test notification token is expired or the notification and status are not yet available.',
        };
    }

    public function toResponse(): array
    {
        return [
            'errorCode' => $this->value,
            'errorMessage' => $this->getMessage(),
        ];
    }
}
