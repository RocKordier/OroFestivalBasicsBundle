<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Form\FormHandler;

use Doctrine\ORM\EntityManagerInterface;
use EHDev\FestivalBasicsBundle\Entity\Festival;
use EHDev\FestivalBasicsBundle\Entity\FestivalAccount;
use EHDev\FestivalBasicsBundle\Form\DataObject\AddFestivalAccountDOT;
use Oro\Bundle\FormBundle\Form\Exception\FormException;
use Oro\Bundle\FormBundle\Form\Handler\FormHandlerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class FestivalAccountAddFestivalHandler implements FormHandlerInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function process($data, FormInterface $form, Request $request)
    {
        if ($request->isMethod(Request::METHOD_GET)) {
            return ;
        }

        if (!$data instanceof AddFestivalAccountDOT) {
            throw new \InvalidArgumentException('wrong DataObject given');
        }

        if (!$request->isMethod(Request::METHOD_POST)) {
            throw new MethodNotAllowedHttpException([Request::METHOD_POST], 'Method not allowed');
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var AddFestivalAccountDOT $data */
            $data = $form->getData();

            if (!$data->getFestival() instanceof Festival && !$data->getFestivalAccount() instanceof FestivalAccount) {
                throw new FormException('$data is invalide');
            }

            $this->entityManager->persist($data->getFestival());
            $this->entityManager->flush();
        }

        return true;
    }
}
