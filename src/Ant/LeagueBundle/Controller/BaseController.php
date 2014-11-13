<?php


namespace Ant\LeagueBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;

use JMS\Serializer\SerializationContext;

/**
 * @author pc
 */
class BaseController extends FOSRestController
{
	/**
	 * Builds a RESTfull view of the entity with HATEOAS links
	 *
	 * @param mixed $entity The entity to be represented
	 * @param int $statusCode The HTTP status code to be returned by the response, the default is 200
	 * @param string $contextGroup The serialization context to be used, the default is null
	 *
	 * @return Response
	 */
	protected function buildResourceView($entity, $statusCode = 200, $contextGroup = null)
	{
		
		return $this->buildView($entity, $statusCode, $contextGroup);
	}
	
	/**
	 * Builds a RESTfull view of the entity
	 *
	 * @param mixed $entity The entity to be represented
	 * @param int $statusCode The HTTP status code to be returned by the response
	 * @param string $contextGroup The serialization context to be used, the default is null
	 * @param boolean $enableMaxDepth Specifie if related objectts should be serialized, the default is true
	 *
	 * @return Response
	 */
	public function buildView($entity, $statusCode, $contextGroup = null, $enableMaxDepth = true)
	{
		$view = $this->view($entity, $statusCode);
	
		$context = $this->createSeralizationContext($contextGroup, $enableMaxDepth);
	
		$view->setSerializationContext($context);
		return $this->handleView($view);
	}
	
	/**
	 * Creates a serialization context
	 *
	 * @param string $contextGroup The name of the context
	 * @param int $enableMaxDepth
	 *
	 * @return \JMS\Serializer\SerializationContext
	 */
	private function createSeralizationContext($contextGroup, $enableMaxDepth)
	{
		$context = SerializationContext::create();
		if($enableMaxDepth){
			$context->enableMaxDepthChecks();
		}
		if($contextGroup != null){
			$context->setGroups(array($contextGroup));
		}
		return $context;
	}
	
	/**
	 * Creates an error view renders it
	 * @param Form $form The form with errors
	 *
	 * @return Response
	 */
	protected function buildFormErrorsView($form, $errorCodeName='channel.form.defaultError')
	{
		$view = $this->createFormErrorsView($form,400,$errorCodeName);
		return $this->handleView($view);
	}
	
	/**
	 * Creates an error view for the form
	 * @param Form $form The form with errors
	 * @param int $statusCode The HTTP status code to be returned by the response, the default is 400
	 *
	 * @return View
	 */
	protected function createFormErrorsView($form, $statusCode = 400, $errorCodeName = 'channel.form.defaultError')
	{
		$errors = $this->getErrorMessages($form);
		$view = $this->view($errors, $statusCode);
		return $view;
	}
	
	protected function getErrorMessages(\Symfony\Component\Form\Form $form) {
		$errors = array();
		
		foreach ($form->all() as $child) {
			if (!$child->isValid()) {
				$errors[$child->getName()] = $this->getErrorMessages($child);
			}
		}
		foreach ($form->getErrors() as $key => $error) {
			$errors[] = $error->getMessage();
		}
	
		return $errors;
	}
}