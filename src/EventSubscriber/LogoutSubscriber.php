<?php

namespace App\EventSubscriber;

use App\Service\ApiLog;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\LogoutEvent;
use App\Service\PostLogsService;
use DateTimeImmutable;

class LogoutSubscriber implements EventSubscriberInterface
{
    private $apiLog;

    public function __construct(ApiLog $apiLog)
    {
        $this->apiLog = $apiLog;
    }

    public function onLogoutEvent(LogoutEvent $event)
    {
        // Récupérer l'email de l'utilisateur connecté avant la déconnexion
        $user = $event->getToken()->getUser();
        $userEmail = $user ? $user->getEmail() : null;

        if ($userEmail) {
            $logData = [
                'loggerName' => 'logout',
                'user' => $userEmail,
                'level' => 'INFO',
                'message' => 'Utilisateur déconnecté',
                'data' => []
            ];

            try {
                $this->apiLog->postLog($logData);
            } catch (\Throwable $th) {
            };
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            LogoutEvent::class => 'onLogoutEvent',
        ];
    }
}
