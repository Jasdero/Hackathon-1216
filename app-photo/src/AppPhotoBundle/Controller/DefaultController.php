<?php

namespace AppPhotoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\UserBundle\Model\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="default")
	 * Redirects to user page if the user is signed in, register otherwise
     */
    public function indexAction()
    {
		$user = $this->getUser();
		if (is_object($user) && $user instanceof UserInterface) {
			return $this->redirectToRoute('fos_user_profile_show');
		}
		return $this->render('@AppPhoto/Default/index.html.twig', array(
			'user' => $user,
		));
    }


    /**
     * @Route("/profil", name="profil")
     *
     */

    public function profilAction()
    {
        $user = $this->getUser();

        return $this->render('@AppPhoto/Default/profil.html.twig', array(
            'user' => $user,
        ));
    }

}
