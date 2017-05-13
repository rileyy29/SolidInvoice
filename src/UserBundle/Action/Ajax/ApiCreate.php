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
use CSBill\UserBundle\Entity\ApiToken;
use CSBill\UserBundle\Form\Handler\ApiFormHandler;
use SolidWorx\FormHandler\FormHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class ApiCreate implements AjaxResponse
{
    /**
     * @var FormHandler
     */
    private $handler;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    public function __construct(FormHandler $handler, TokenStorageInterface $tokenStorage)
    {
        $this->handler = $handler;
        $this->tokenStorage = $tokenStorage;
    }

    public function __invoke(Request $request)
    {
        $apiToken = new ApiToken();
        $apiToken->setUser($this->tokenStorage->getToken()->getUser());

        return $this->handler->handle(ApiFormHandler::class, $apiToken);
    }
}
