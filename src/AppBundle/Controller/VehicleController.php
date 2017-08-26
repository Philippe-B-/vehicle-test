<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Vehicle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Vehicle controller.
 *
 * @Route("vehicle")
 */
class VehicleController extends Controller
{
    /**
     * Lists all vehicle entities.
     *
     * @Route("/", name="vehicle_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $vehicles = $em->getRepository('AppBundle:Vehicle')->findAll();

        return $this->render('@App/vehicle/index.html.twig', array(
            'vehicles' => $vehicles,
        ));
    }

    /**
     * Creates a new vehicle entity.
     *
     * @Route("/new", name="vehicle_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $vehicleTypes = $this->getParameter('vehicle_types');

        $vehicle = new Vehicle();
        $form = $this->createForm('AppBundle\Form\VehicleType', $vehicle, array('vehicle_types' => $vehicleTypes));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($vehicle);
            $em->flush();

            return $this->redirectToRoute('vehicle_show', array('id' => $vehicle->getId()));
        }

        return $this->render('@App/vehicle/new.html.twig', array(
            'vehicle' => $vehicle,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a vehicle entity.
     *
     * @Route("/{id}", name="vehicle_show")
     * @Method("GET")
     */
    public function showAction(Vehicle $vehicle)
    {
        $deleteForm = $this->createDeleteForm($vehicle);

        return $this->render('@App/vehicle/show.html.twig', array(
            'vehicle' => $vehicle,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing vehicle entity.
     *
     * @Route("/{id}/edit", name="vehicle_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Vehicle $vehicle)
    {
        $vehicleTypes = $this->getParameter('vehicle_types');

        $deleteForm = $this->createDeleteForm($vehicle);
        $editForm = $this->createForm('AppBundle\Form\VehicleType', $vehicle, array('vehicle_types' => $vehicleTypes));
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vehicle_show', array('id' => $vehicle->getId()));
        }

        return $this->render('@App/vehicle/edit.html.twig', array(
            'vehicle' => $vehicle,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a vehicle entity.
     *
     * @Route("/{id}", name="vehicle_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Vehicle $vehicle)
    {
        $form = $this->createDeleteForm($vehicle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($vehicle);
            $em->flush();
        }

        return $this->redirectToRoute('vehicle_index');
    }

    /**
     * Creates a form to delete a vehicle entity.
     *
     * @param Vehicle $vehicle The vehicle entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Vehicle $vehicle)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vehicle_delete', array('id' => $vehicle->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
