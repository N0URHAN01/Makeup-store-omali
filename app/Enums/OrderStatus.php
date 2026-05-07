<?php

namespace App\Enums;

class OrderStatus
{
    public const PENDING = 'pending';
    public const CONFIRMED = 'confirmed';
    public const PROCESSING = 'processing';
    public const SHIPPED = 'shipped';
    public const OUT_FOR_DELIVERY = 'out_for_delivery';
    public const DELIVERED = 'delivered';

    public const CANCELLED = 'cancelled';
    public const REJECTED = 'rejected';
    public const FAILED_DELIVERY = 'failed_delivery';
    public const RETURN_REQUESTED = 'return_requested';
    public const RETURNED = 'returned';

    public static function all(): array
    {
        return [
            self::PENDING,
            self::CONFIRMED,
            self::PROCESSING,
            self::SHIPPED,
            self::OUT_FOR_DELIVERY,
            self::DELIVERED,
            self::CANCELLED,
            self::REJECTED,
            self::FAILED_DELIVERY,
            self::RETURN_REQUESTED,
            self::RETURNED,
        ];
    }

    public static function label(string $status): string
    {
        return match ($status) {
            self::PENDING => 'Pending',
            self::CONFIRMED => 'Confirmed',
            self::PROCESSING => 'Processing',
            self::SHIPPED => 'Shipped',
            self::OUT_FOR_DELIVERY => 'Out For Delivery',
            self::DELIVERED => 'Delivered',

            self::CANCELLED => 'Cancelled',
            self::REJECTED => 'Rejected',
            self::FAILED_DELIVERY => 'Failed Delivery',
            self::RETURN_REQUESTED => 'Return Requested',
            self::RETURNED => 'Returned',

            default => ucfirst($status),
        };
    }

    public static function color(string $status): string
    {
        return match ($status) {
            self::PENDING => 'bg-yellow-100 text-yellow-800',

            self::CONFIRMED => 'bg-blue-100 text-blue-800',

            self::PROCESSING => 'bg-indigo-100 text-indigo-800',

            self::SHIPPED => 'bg-purple-100 text-purple-800',

            self::OUT_FOR_DELIVERY => 'bg-fuchsia-100 text-fuchsia-800',

            self::DELIVERED => 'bg-green-100 text-green-800',

            self::CANCELLED => 'bg-red-100 text-red-800',

            self::REJECTED => 'bg-red-200 text-red-900',

            self::FAILED_DELIVERY => 'bg-orange-100 text-orange-800',

            self::RETURN_REQUESTED => 'bg-pink-100 text-pink-800',

            self::RETURNED => 'bg-gray-200 text-gray-800',

            default => 'bg-gray-100 text-gray-700',
        };
    }
}