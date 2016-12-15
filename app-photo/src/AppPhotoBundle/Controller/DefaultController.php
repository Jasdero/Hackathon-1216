<?php

namespace AppPhotoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\UserBundle\Model\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use AppPhotoBundle\Entity\User;


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

    public function profilAction(Request $request)
    {
        $user = $this->getUser();

        $editForm = $this->createForm('AppPhotoBundle\Form\UserType', $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('profil');
        }

        return $this->render('@AppPhoto/Default/profil.html.twig', array(
            'user' => $user,
            'edit_form' => $editForm->createView(),
        ));
    }

    public function editProfileAction(Request $request, User $user)
    {

    }

}
