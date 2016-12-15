<?php

namespace AppPhotoBundle\Controller;

use AppPhotoBundle\Entity\Game;
use AppPhotoBundle\Entity\GameAnswer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Gameanswer controller.
 *
 * @Route("gameanswer")
 */
class GameAnswerController extends Controller
{
    /**
     * Lists all gameAnswer entities.
     *
     * @Route("/", name="gameanswer_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $gameAnswers = $em->getRepository('AppPhotoBundle:GameAnswer')->findAll();

        return $this->render('@AppPhoto/gameanswer/index.html.twig', array(
            'gameAnswers' => $gameAnswers,
        ));
    }

    /**
     * Creates a new gameAnswer entity.
     *
     * @Route("/{id}/new", name="gameanswer_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Game $game)
    {
        $gameAnswer = new Gameanswer();
        $form = $this->createForm('AppPhotoBundle\Form\GameAnswerType', $gameAnswer);
        $form->remove('game')->remove('user');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
			$gameAnswer->setGame($game)->setUser($this->getUser());
			// On envoie la notification de réponse au game leader
			$game->answerNotice($this);
            $em = $this->getDoctrine()->getManager();
            $em->persist($gameAnswer);
            $em->flush($gameAnswer);

            return $this->redirectToRoute('gameanswer_show', array('id' => $gameAnswer->getId()));
        }

        return $this->render('@AppPhoto/gameanswer/new.html.twig', array(
            'gameAnswer' => $gameAnswer,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a gameAnswer entity.
     *
     * @Route("/{id}", name="gameanswer_show")
     * @Method("GET")
     */
    public function showAction(GameAnswer $gameAnswer)
    {
        $deleteForm = $this->createDeleteForm($gameAnswer);

        return $this->render('@AppPhoto/gameanswer/show.html.twig', array(
            'gameAnswer' => $gameAnswer,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing gameAnswer entity.
     *
     * @Route("/{id}/edit", name="gameanswer_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, GameAnswer $gameAnswer)
    {
        $deleteForm = $this->createDeleteForm($gameAnswer);
        $editForm = $this->createForm('AppPhotoBundle\Form\GameAnswerType', $gameAnswer);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('gameanswer_edit', array('id' => $gameAnswer->getId()));
        }

        return $this->render('@AppPhoto/gameanswer/edit.html.twig', array(
            'gameAnswer' => $gameAnswer,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a gameAnswer entity.
     *
     * @Route("/{id}", name="gameanswer_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, GameAnswer $gameAnswer)
    {
        $form = $this->createDeleteForm($gameAnswer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($gameAnswer);
            $em->flush($gameAnswer);
        }

        return $this->redirectToRoute('gameanswer_index');
    }

    /**
     * Creates a form to delete a gameAnswer entity.
     *
     * @param GameAnswer $gameAnswer The gameAnswer entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(GameAnswer $gameAnswer)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('gameanswer_delete', array('id' => $gameAnswer->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
