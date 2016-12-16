<?php

namespace AppPhotoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\UserBundle\Model\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;

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
			return $this->redirectToRoute('index', array(
                'user' => $user,
            ));
		}
		return $this->redirectToRoute('fos_user_security_login');
    }


    /**
     * @Route("/profil", name="profil")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
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


    /**
     * @Route("/edit/avatar", name="editAvatar")
     *
     */

    public function profilAvatarAction(Request $request)
    {
        $user = $this->getUser();



        $editForm = $this->createForm('AppPhotoBundle\Form\UserPhotoType', $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $user = $editForm->getData();
            $avatar = $user->getAvatar();
            $fileName = md5(uniqid()).'.'.$avatar->guessExtension();
            $avatar->move(
                $this->getParameter('upload_directory'),
                $fileName
            );
            $user->setAvatar($fileName);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('profil');
        }

        return $this->render('@AppPhoto/Default/editPhoto.html.twig', array(
            'user' => $user,
            'edit_form' => $editForm->createView(),
        ));
    }


    public function headerAction()
    {
        $user = $this->getUser();
        return $this->render('@AppPhoto/Default/header.html.twig', array(
            'user' => $user,
        ));
    }
    /**
     * @Route("/index", name="index")
     *
     */
    public function baseAction()
    {
        return $this->render('@AppPhoto/Default/index.html.twig');
    }





}
>>>>>>> master
