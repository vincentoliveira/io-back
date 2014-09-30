<?php

namespace IO\RestaurantBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JMS\DiExtraBundle\Annotation\Inject;

use IO\RestaurantBundle\Entity\Restaurant;
use IO\RestaurantBundle\Form\RestaurantType;
use IO\RestaurantBundle\Form\RestaurantEditType;

/**
 * Restaurant controller.
 *
 * @Route("/admin/restaurant")
 */
class RestaurantController extends Controller
{

    /**
     * Restaurant Service
     * 
     * @Inject("io.restaurant_service")
     * @var \IO\RestaurantBundle\Service\RestaurantService
     */
    public $restaurantSv;
    
    /**
     * Lists all Restaurant entities.
     *
     * @Route("/", name="restaurant_admin")
     * @Method("GET")
     * @Secure(roles="ROLE_GROUP_MANAGER")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $restaurantGroups = $em->getRepository('IORestaurantBundle:RestaurantGroup')->findAll();

        return array(
            'restaurant_groups' => $restaurantGroups,
        );
    }
    /**
     * Creates a new Restaurant entity.
     *
     * @Route("/", name="restaurant_admin_create")
     * @Method("POST")
     * @Secure(roles="ROLE_GROUP_MANAGER")
     * @Template("IORestaurantBundle:Restaurant:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Restaurant();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $entity = $this->restaurantSv->createDefaultValue($entity);
            $entity = $this->handlePhoneAndAddress($entity);
            
            // handle manager
            $manager = $entity->getManager();
            $manager->setEnabled(true);
            $manager->setRoles(['ROLE_MANAGER', 'ROLE_GROUP_MANAGER']);
            $entity->getGroup()->setManager($manager);
            
            $em->persist($manager);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('restaurant_admin_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Restaurant entity.
     *
     * @param Restaurant $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Restaurant $entity)
    {
        $form = $this->createForm(new RestaurantType(), $entity, array(
            'action' => $this->generateUrl('restaurant_admin_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Créer un restaurant',
            'attr' => array('class' => 'btn btn-primary'),
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Restaurant entity.
     *
     * @Route("/new", name="restaurant_admin_new")
     * @Method("GET")
     * @Secure(roles="ROLE_GROUP_MANAGER")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Restaurant();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Restaurant entity.
     *
     * @Route("/{id}", name="restaurant_admin_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IORestaurantBundle:Restaurant')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Restaurant entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Restaurant entity.
     *
     * @Route("/{id}/edit", name="restaurant_admin_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IORestaurantBundle:Restaurant')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Restaurant entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Restaurant entity.
    *
    * @param Restaurant $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Restaurant $entity)
    {
        $form = $this->createForm(new RestaurantEditType(), $entity, array(
            'action' => $this->generateUrl('restaurant_admin_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Modifier',
            'attr' => array('class' => 'btn btn-primary'),
        ));

        return $form;
    }
    /**
     * Edits an existing Restaurant entity.
     *
     * @Route("/{id}", name="restaurant_admin_update")
     * @Method("PUT")
     * @Template("IORestaurantBundle:Restaurant:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IORestaurantBundle:Restaurant')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Restaurant entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $entity = $this->handlePhoneAndAddress($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('restaurant_admin_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Restaurant entity.
     *
     * @Route("/{id}", name="restaurant_admin_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('IORestaurantBundle:Restaurant')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Restaurant entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('restaurant_admin'));
    }

    /**
     * Creates a form to delete a Restaurant entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('restaurant_admin_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array(
                'label' => 'Supprimer',
                'attr' => array('class' => 'btn btn-danger'),
            ))
            ->getForm()
        ;
    }
    
    private function handlePhoneAndAddress(Restaurant $entity)
    {
        // handle phone
        $phoneNumber = $entity->getPhone()->getNumber();
        if (empty($phoneNumber)) {
            $entity->setPhone();
        }

        // handle address
        $address = $entity->getAddress();
        $addressNumber = $address->getNumber();
        $addressStreet = $address->getStreet();
        $addressPostcode = $address->getPostCode();
        $addressCity = $address->getCity();
        $addressCountry = $address->getCountry();
        if (empty($addressNumber) || empty($addressStreet) || 
                empty($addressPostcode) || empty($addressCity) || 
                empty($addressCountry)) {
            $entity->setAddress();
        }

        return $entity;
    }
}
