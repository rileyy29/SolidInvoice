<?php

declare(strict_types=1);

/*
 * This file is part of CSBill project.
 *
 * (c) 2013-2017 Pierre du Plessis <info@customscripts.co.za>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CSBill\UserBundle\Action\Ajax;

use CSBill\CoreBundle\Response\AjaxResponse;
use CSBill\CoreBundle\Traits\SerializeTrait;
use CSBill\UserBundle\Repository\ApiTokenRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class ApiList implements AjaxResponse
{
    use SerializeTrait;

    /**
     * @var ApiTokenRepository
     */
    private $repository;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    public function __construct(ApiTokenRepository $repository, TokenStorageInterface $tokenStorage)
    {
        $this->repository = $repository;
        $this->tokenStorage = $tokenStorage;
    }

    public function __invoke(Request $request)
    {
        $token = $this->tokenStorage->getToken();
        $user = $token ? $token->getUser() : null;

        if ($user) {
            $tokens = $this->repository->getApiTokensForUser($user);

            return $this->serialize($tokens);
        }

        return $this->serialize([]);
    }
}
