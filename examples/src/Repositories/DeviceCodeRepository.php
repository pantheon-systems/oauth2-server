<?php

/**
 * @author    Andrew Millington <andrew@noexceptions.io>
 * @copyright Copyright (c) Alex Bilbie
 * @license   http://mit-license.org/
 *
 * @link      https://github.com/thephpleague/oauth2-server
 */

declare(strict_types=1);

namespace OAuth2ServerExamples\Repositories;

use DateTimeImmutable;
use League\OAuth2\Server\Entities\DeviceCodeEntityInterface;
use League\OAuth2\Server\Repositories\DeviceCodeRepositoryInterface;
use OAuth2ServerExamples\Entities\ClientEntity;
use OAuth2ServerExamples\Entities\DeviceCodeEntity;
use OAuth2ServerExamples\Entities\ScopeEntity;

class DeviceCodeRepository implements DeviceCodeRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getNewDeviceCode(): DeviceCodeEntityInterface
    {
        return new DeviceCodeEntity();
    }

    /**
     * {@inheritdoc}
     */
    public function persistDeviceCode(DeviceCodeEntityInterface $deviceCodeEntity): void
    {
        // Some logic to persist a new device code to a database
    }

    /**
     * {@inheritdoc}
     */
    public function getDeviceCodeEntityByDeviceCode($deviceCode): ?DeviceCodeEntityInterface
    {
        $clientEntity = new ClientEntity();
        $clientEntity->setIdentifier('myawesomeapp');

        $deviceCodeEntity = new DeviceCodeEntity();

        $deviceCodeEntity->setIdentifier($deviceCode);
        $deviceCodeEntity->setExpiryDateTime(new DateTimeImmutable('now +1 hour'));
        $deviceCodeEntity->setClient($clientEntity);
        $deviceCodeEntity->setLastPolledAt(new DateTimeImmutable());

        $scopes = [];
        foreach ($scopes as $scope) {
            $scopeEntity = new ScopeEntity();
            $scopeEntity->setIdentifier($scope);
            $deviceCodeEntity->addScope($scopeEntity);
        }

        // The user identifier should be set when the user authenticates on the
        // OAuth server, along with whether they approved the request
        $deviceCodeEntity->setUserApproved(true);
        $deviceCodeEntity->setUserIdentifier('1');

        return $deviceCodeEntity;
    }

    /**
     * {@inheritdoc}
     */
    public function revokeDeviceCode($codeId): void
    {
        // Some logic to revoke device code
    }

    /**
     * {@inheritdoc}
     */
    public function isDeviceCodeRevoked($codeId): bool
    {
        return false;
    }
}
