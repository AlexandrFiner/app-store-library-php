<?php

namespace AppStoreLibrary\Enums\ConnectApi;

enum ResourceType: string
{
    case Subscriptions = 'subscriptions';
    case SubscriptionGroups = 'subscriptionGroups';
    case SubscriptionPrices = 'subscriptionPrices';
    case SubscriptionIntroductoryOffers = 'subscriptionIntroductoryOffers';
    case SubscriptionPricePoints = 'subscriptionPricePoints';
    case SubscriptionLocalizations = 'subscriptionLocalizations';
    case SubscriptionAvailabilities = 'subscriptionAvailabilities';
    case SubscriptionAppStoreReviewScreenshots = 'subscriptionAppStoreReviewScreenshots';
    case Territories = 'territories';
}
