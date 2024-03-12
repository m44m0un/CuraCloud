<?php

namespace App\EventSubscriber;

use App\Entity\Appointment;
use App\Repository\AppointmentRepository;
use CalendarBundle\CalendarEvents;
use CalendarBundle\Event\CalendarEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CalendarSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private AppointmentRepository $appointmentRepository,
        private UrlGeneratorInterface $router
    ) {}

    public static function getSubscribedEvents()
    {
        return [
            CalendarEvents::SET_DATA => 'onCalendarSetData',
        ];
    }

    public function onCalendarSetData(CalendarEvent $calendar)
    {
        $start = $calendar->getStart();
        $end = $calendar->getEnd();
        $filters = $calendar->getFilters();

        $appointments = $this->appointmentRepository
            ->createQueryBuilder('appointment')
            ->where('appointment.startDate BETWEEN :start and :end OR appointment.endDate BETWEEN :start and :end')
            ->setParameter('start', $start->format('Y-m-d H:i:s'))
            ->setParameter('end', $end->format('Y-m-d H:i:s'))
            ->getQuery()
            ->getResult();
          
        foreach ($appointments as $appointment) {
                
            $calendarEvent = new \CalendarBundle\Entity\Event(
                $appointment->getDescription(),
                $appointment->getStartDate(),
                $appointment->getEndDate()
            );

            /*
             * Add custom options to events
             *
             * For more information see: https://fullcalendar.io/docs/event-object
             * and: https://github.com/fullcalendar/fullcalendar/blob/master/src/core/options.ts
             */

             $calendarEvent->setOptions([

                'className' => ['fc-event-primary'], // Add more classes as needed

            ]);
            
            $calendarEvent->addOption(
                'url',
                $this->router->generate('admin_app_appointment_show', [
                    'id' => $appointment->getId(),
                ])
            );

            $calendar->addEvent($calendarEvent);
        }
    }
}
