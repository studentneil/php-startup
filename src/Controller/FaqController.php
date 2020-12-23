<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FaqController extends AbstractController
{
	/**
	 *@Route("/faq", name="faq")
	 */
	public function faqAction(): \Symfony\Component\HttpFoundation\Response
	{
		$templateName = 'frontend/faq';
		return $this->render($templateName.'.html.twig', []);
	}
}