<?php

namespace ForumBundle\Controller;

use ForumBundle\Entity\Sujet;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Sujet controller.
 *
 */
class SujetController extends Controller
{
    /**
     * Lists all sujet entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $sujets = $em->getRepository('ForumBundle:Sujet')->findAll();

        return $this->render('@Forum/Sujet/index.html.twig', array(
            'sujets' => $sujets,
        ));
    }

    /**
     * Creates a new sujet entity.
     *
     */
    public function newAction(Request $request)
    {
        $sujet = new Sujet();
        $form = $this->createForm('ForumBundle\Form\SujetType', $sujet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($sujet);
            $em->flush();

            return $this->redirectToRoute('sujet_show', array('idSujet' => $sujet->getIdsujet()));
        }

        return $this->render('@Forum/Sujet/new.html.twig', array(
            'sujet' => $sujet,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a sujet entity.
     *
     */
    public function showAction(Sujet $sujet)
    {
        $deleteForm = $this->createDeleteForm($sujet);

        return $this->render('@Forum/Sujet/show.html.twig', array(
            'sujet' => $sujet,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing sujet entity.
     *
     */
    public function editAction(Request $request, Sujet $sujet)
    {
        $deleteForm = $this->createDeleteForm($sujet);
        $editForm = $this->createForm('ForumBundle\Form\SujetType', $sujet);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sujet_edit', array('idSujet' => $sujet->getIdsujet()));
        }

        return $this->render('@Forum/Sujet/edit.html.twig', array(
            'sujet' => $sujet,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a sujet entity.
     *
     */
    public function deleteAction(Request $request, Sujet $sujet)
    {
        $form = $this->createDeleteForm($sujet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($sujet);
            $em->flush();
        }

        return $this->redirectToRoute('sujet_index');
    }

    /**
     * Creates a form to delete a sujet entity.
     *
     * @param Sujet $sujet The sujet entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Sujet $sujet)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('sujet_delete', array('idSujet' => $sujet->getIdsujet())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
