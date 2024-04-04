<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @author Efflam <cefflam@gmail.com>
 */

class LocaleController extends AbstractController
{
    #[Route('/switch-locale/{locale}', name: 'app_switch_locale')]
    public function switchLocale(Request $request, $locale): RedirectResponse
    {
        $request->getSession()->set('_locale', $locale);

        $referer = $request->headers->get('referer');
        if (empty($referer)) {
            $referer = $this->generateUrl('app_home'); // Replace 'homepage' with the route name of your homepage
        }

        return new RedirectResponse($referer);
    }
}

