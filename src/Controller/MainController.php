<?php

namespace App\Controller;

use App\Entity\Entries;
use App\Services\EstelabFunctions;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

class MainController extends AbstractController
{
    /**
     * @Route("/{entryCode}", name="index")
     */
    public function index($entryCode)
    {
        $repository = $this->getDoctrine()->getRepository(Entries::class);
        $entry = $repository->findOneBy(['shortUrlCode' => $entryCode]);

        if (!$entry) {
            throw $this->createNotFoundException();
        } else {
            $dateTimeNow = new DateTime();
            $entryDateTime = $entry->getEntryDate();

            if ($dateTimeNow > $entryDateTime) {
                throw $this->createNotFoundException();
            } else {
                return $this->render('main/index.html.twig', [
                    'entry_id' => $entry->getId(),
                    'patient_name' => $entry->getName(),
                    'entry_code' => $entryCode,
                ]);
            }
        }

    }

    /**
     * @Route("/entry/new", name="newEntry", methods={"POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function newEntry(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Entries::class);
        $entityManager = $this->getDoctrine()->getManager();

        $name = $request->query->get('name');
        $timestamp = $request->query->getInt('timestamp');
        $dateTime = new DateTime("@$timestamp");

        $urlCOde = EstelabFunctions::generateUrlCode($repository, 8);
        $entry = new Entries();

        if ($name) {
            $entry->setName($name);
        }

        $entry->setShortUrlCode($urlCOde);
        $entry->setEntryDate($dateTime);
        $entityManager->persist($entry);
        $entityManager->flush();

        return $this->json([
            'id' => $entry->getId(),
            'code' => $urlCOde,
        ]);
    }


}
