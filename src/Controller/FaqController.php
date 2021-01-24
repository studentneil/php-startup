<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route as Route;

class FaqController extends AbstractController
{
	/**
	 *@Route("/faq", name="faq")
	 */
	public function faqAction(): Response
	{
		$templateName = 'frontend/faq';
		return $this->render($templateName.'.html.twig', []);
	}
}