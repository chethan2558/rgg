<?php

namespace Rgg\SearchBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/search")
 * @Security("has_role('ROLE_USER')")
 */
class SearchController extends Controller
{
	/**
     * @Route("/query")
     */
	public function queryAction(Request $request)
	{
		$form = $this->createFormBuilder()
			->add('query', null, [
				'attr' => [
					'minlength' => 4,
					'maxlength' => 20
				]])
			->add('priceAsc', 'checkbox', [
					'label' => 'Prize ASC',
					'required' => false,
				])
			->add('submit', 'submit', ['label' => 'Search'])
			->getForm();

		$form->handleRequest($request);

		$searchResult = '';

		if($form->isValid()) {
			$queryData = $form->get('query')->getData();
			$priceAsc = $form->get('priceAsc')->getData();
			$isAdmim = $this->getUser()->hasRole('ROLE_ADMIN');

			$searchResult = $this->container->get('rgg.searchbundle.search')->query($queryData, $priceAsc, $isAdmim);
		}

		return $this->render('SearchBundle::query.html.twig',
			[
				'form'	=> $form->createView(),
				'results' => $searchResult
			]
		);
	}
}
