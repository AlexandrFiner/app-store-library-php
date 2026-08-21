<?php

namespace AppStoreLibrary\Enums\ServerApi;

enum RetentionMessageState: string
{
    case Pending = 'PENDING';
    case Approved = 'APPROVED';
    case Rejected = 'REJECTED';
}
