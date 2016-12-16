<?php

namespace AppPhotoBundle\Controller;

use AppPhotoBundle\Entity\Game;
use AppPhotoBundle\Entity\GameAnswer;
use AppPhotoBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Game controller.
 *
 * @Route("game")
 */
class GameController extends Controller
{
	/**
	 * Validates a GameAnswer and ends a game turn
	 *
	 * @Route("/{id}/end_turn", name="game_end_turn")
	 * @Method({"GET", "POST"})
	 */
	public function endTurnAction(Request $request, GameAnswer $gameAnswer)
	{
		$game = $gameAnswer->getGame();
		$em = $this->getDoctrine()->getManager();
		$game->setLeader($gameAnswer->getUser());
		$propositions = $game->getPropositions();
		foreach($propositions as $rejectedAnswer) {
			unlink($this->container->getParameter('upload_directory').$rejectedAnswer->getImage()->getImage());
			$game->removeProposition($rejectedAnswer);
			$em->remove($rejectedAnswer);
			$em->flush($game);
		}
		$initialImage = $game->getToGuessImage();
		$game->setToGuessImage(null);
		unlink($this->container->getParameter('upload_directory').$initialImage->getImage());
		$em->remove($initialImage);
		$em->flush();
		return $this->redirectToRoute('game_index', array('id' => $game->getId()));

	}

	/**
	 * Starts a new game turn (gets a new image from the game leader and increments their points)
	 *
	 * @Route("/{id}/start_turn", name="game_start_turn")
	 * @Method({"GET", "POST"})
	 */
	public function startTurnAction(Request $request, Game $game)
	{
		$deleteForm = $this->createDeleteForm($game);
		$editForm = $this->createForm('AppPhotoBundle\Form\GameType', $game);
		$editForm->remove('leader');
		$editForm->handleRequest($request);

		if ($editForm->isSubmitted() && $editForm->isValid()) {
			$game->getLeader()->addScore(1);
			$this->getDoctrine()->getManager()->flush();
			return $this->redirectToRoute('game_edit', array('id' => $game->getId()));
		}

		return $this->render('@AppPhoto/game/edit.html.twig', array(
			'game' => $game,
			'edit_form' => $editForm->createView(),
			'delete_form' => $deleteForm->createView(),
		));

	}

    /**
     * Lists all game entities.
     *
     * @Route("/", name="game_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $games = $em->getRepository('AppPhotoBundle:Game')->findAll();
        //$games = $em->getRepository('AppPhotoBundle:Game')->findAllActive();

        return $this->render('@AppPhoto/game/index.html.twig', array(
            'games' => $games,
        ));
    }

    /**
     * Creates a new game entity.
     *
     * @Route("/new", name="game_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $game = new Game();
        $form = $this->createForm('AppPhotoBundle\Form\GameType', $game);
		$form->remove('leader');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
			$game->setLeader($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($game);
            $em->flush($game);

            return $this->redirectToRoute('game_show', array(
            	'id' => $game->getId(),
			));
        }

        return $this->render('@AppPhoto/game/new.html.twig', array(
            'game' => $game,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a game entity.
     *
     * @Route("/{id}", name="game_show")
     * @Method("GET")
     */
    public function showAction(Game $game)
    {
        $deleteForm = $this->createDeleteForm($game);
        $user = $this->getUser();
		$isLeader = ($game->getLeader() == $user);
		$table = [
			'game' => $game,
			'delete_form' => $deleteForm->createView(),
			'is_leader' => $isLeader,
			'user' => $user,
		];
		if ($isLeader)
			$table['answers'] = $game->getPropositions();
        return $this->render('@AppPhoto/game/show.html.twig', $table);
    }

    /**
     * Displays a form to edit an existing game entity.
     *
     * @Route("/{id}/edit", name="game_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Game $game)
    {
        $deleteForm = $this->createDeleteForm($game);
        $editForm = $this->createForm('AppPhotoBundle\Form\GameType', $game);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('game_edit', array('id' => $game->getId()));
        }

        return $this->render('@AppPhoto/game/edit.html.twig', array(
            'game' => $game,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a game entity.
     *
     * @Route("/{id}", name="game_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Game $game)
    {
        $form = $this->createDeleteForm($game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($game);
            $em->flush($game);
        }

        return $this->redirectToRoute('game_index');
    }

    /**
     * Creates a form to delete a game entity.
     *
     * @param Game $game The game entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Game $game)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('game_delete', array('id' => $game->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
