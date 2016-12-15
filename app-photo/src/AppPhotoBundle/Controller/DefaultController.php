<?php

namespace AppPhotoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="default")
	 * Redirects to user page if the user is signed in, register otherwise
     */
    public function indexAction()
    {
		$user = $this->getUser();
		if (!is_object($user) || !$user instanceof UserInterface) {
			throw new AccessDeniedException('This user does not have access to this section.');
		}
		return $this->redirectToRoute('fos_user_profile_show');
    }
}
