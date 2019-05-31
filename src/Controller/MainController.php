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
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;

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
            setlocale(LC_ALL, 'ru_RU', 'ru_RU.UTF-8', 'ru', 'russian');
            $dateTimeNow = new DateTime();
            $entryDateTime = $entry->getEntryDate();

            if ($dateTimeNow > $entryDateTime) {
                throw $this->createNotFoundException();
            } else {
                return $this->render('main/index.html.twig', [
                    'entry_id' => $entry->getId(),
                    'patient_name' => $entry->getName(),
                    'entry_date' => EstelabFunctions::ru_date("%d %bg %Y в %R", $entryDateTime->getTimestamp()),
                    'js_entry_date' => $entryDateTime->format("Ymd\THis"),
                    'entry_code' => $entryCode,
                    'cssVersion' =>  'v11'
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

    public function initCalendarWidget($title = 'Test Title', $startTime, $endTime, $desc, $address, $url) {

        $hrefGoogle = 'https://www.google.com/calendar/render'.
        '?action=TEMPLATE'.
        '&text=' . $title.
        '&dates=' . $startTime.
        '/' . $endTime.
        '&details=' . $desc.
        '&location=' . $address.
        '&sprop=&sprop=name:';

        $hrefApple = 'data:text/calendar;charset=utf8,' .
            implode('%0A',
                [
                    'BEGIN:VCALENDAR',
                    'VERSION:2.0',
                    'BEGIN:VEVENT',
                    'URL:' . $url,
                    'DTSTART:' . $startTime,
                    'DTEND:' . $endTime,
                    'SUMMARY:' . $title,
                    'DESCRIPTION:' . $desc,
                    'LOCATION:' . $address,
                    'END:VEVENT',
                    'END:VCALENDAR'
                ]
            );



        return $this->render(
            'widgets/calendar.html.twig', [
                'href_google' => $hrefGoogle,
                'href_apple' => $hrefApple,
            ]
        );
    }


}
