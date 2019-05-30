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
                    'entry_date' => $entryDateTime->format('d.m.Y H:i'),
                    'js_entry_date' => $entryDateTime->format('D M d Y H:i:s O'),
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
        //$repository = $this->getDoctrine()->getRepository(Entries::class);

        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
            $data = json_decode($request->getContent(), true);
            $request->request->replace(is_array($data) ? $data : array());

            $repository = $this->getDoctrine()->getRepository(Entries::class);
            $entityManager = $this->getDoctrine()->getManager();

            $entry = $repository->findOneBy(['entryId' => $data['externalID']]);
            //$entry = new Entries();
            if (!$entry) {
                $entry = new Entries();

                if (!empty($data['urlCode'])) {
                    $entry->setShortUrlCode($data['urlCode']);
                }
            }

            if (!empty($data['externalID'])) {
                $entry->setEntryId($data['externalID']);
            }

            if (!empty($data['name'])) {
                $entry->setName($data['name']);
            }

            $timestamp = $data['entryTimestamp'];
            $dateTime = new DateTime("@$timestamp");
            $entry->setEntryDate($dateTime);

            $entityManager->persist($entry);
            $entityManager->flush();

            return $this->json([
                'id' => $entry->getId(),
                'urlCode' => $entry->getShortUrlCode(),
            ]);
        }
    }


}
