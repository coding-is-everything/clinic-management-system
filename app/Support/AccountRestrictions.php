<?php

namespace App\Support;

class AccountRestrictions
{
    /**
     * Account statuses that are allowed to complete login.
     *
     * @var list<string>
     */
    protected const ALLOWED_STATUSES = ['active'];

    /**
     * Human-readable restriction copy keyed by the `users.status` enum value.
     *
     * @var array<string, array{title: string, description: string, referenceCode: string}>
     */
    protected const DEFINITIONS = [
        'inactive' => [
            'title' => 'Your account is currently inactive',
            'description' => 'Please contact your clinic administrator to restore access to the clinical portal.',
            'referenceCode' => 'ERR-AUTH-9042',
        ],
        'suspended' => [
            'title' => 'Your account has been suspended',
            'description' => 'This account was suspended by an administrator. Contact your clinic administrator if you believe this is a mistake.',
            'referenceCode' => 'ERR-AUTH-9043',
        ],
        'locked' => [
            'title' => 'Your account is locked',
            'description' => 'This account has been locked for security reasons. Contact your clinic administrator to unlock it.',
            'referenceCode' => 'ERR-AUTH-9044',
        ],
        'pending' => [
            'title' => 'Your account is pending activation',
            'description' => 'Your account has been created but is awaiting activation by your clinic administrator.',
            'referenceCode' => 'ERR-AUTH-9045',
        ],
        'invited' => [
            'title' => "Your invitation hasn't been accepted yet",
            'description' => 'Please check your email for an invitation link, or ask your clinic administrator to resend it.',
            'referenceCode' => 'ERR-AUTH-9046',
        ],
    ];

    protected const FALLBACK = [
        'title' => 'Access to your account is currently restricted',
        'description' => 'Please contact your clinic administrator for assistance.',
        'referenceCode' => 'ERR-AUTH-9040',
    ];

    /**
     * Determine whether the given `users.status` value is allowed to log in.
     */
    public static function allows(?string $status): bool
    {
        return in_array($status, self::ALLOWED_STATUSES, true);
    }

    /**
     * Get the display copy for a restricted account status.
     *
     * @return array{status: string, title: string, description: string, referenceCode: string}
     */
    public static function describe(?string $status): array
    {
        $definition = self::DEFINITIONS[$status] ?? self::FALLBACK;

        return [...$definition, 'status' => $status ?? 'restricted'];
    }
}
