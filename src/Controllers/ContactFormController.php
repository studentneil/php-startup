<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 18/06/2017
 * Time: 00:00
 */

namespace VinylStore\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use VinylStore\Forms\ContactFormType;


class ContactFormController
{
    public function contactFormAction(Request $request, Application $app)
    {

        $contactFormData = array();
        $form = $app['form.factory']
            ->createBuilder(ContactFormType::class, $contactFormData)
            ->getForm();
        $templateName = 'frontend/contact';
        $args_array = array(
            'form' => $form->createView()
        );
        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }

    public function sendContactFormAction(Request $request, Application $app)
    {
        $data = array();
        $form = $app['form.factory']
            ->createBuilder(ContactFormType::class, $data)
            ->getForm();
        $form = $form->handleRequest($request);
        if ($form->isValid()) {
            $data = $form->getData();
            $transport = (new \Swift_SmtpTransport($app['config']['email']['host'], 587, 'tls'))
                ->setUsername($app['config']['email']['username'])
                ->setPassword($app['config']['email']['password'])
                ->setStreamOptions(array('ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )))
                ->setAuthMode('plain');
            $transport->setLocalDomain('[127.0.0.1]');

            $mailer = new \Swift_Mailer($transport);
            $message = (new \Swift_Message('TheRecordBox.ie contact form'))
                ->setFrom(array($app['config']['email']['username'] => 'info'))
                ->setTo(array($app['config']['email']['reciever'] => 'neil'))
                ->setReplyTo(array($data['email'] => $data['name']))
                ->setBody($data['message']);
//          result holds the number of successful recipients
            $result = $mailer->send($message);

            if ($result === 0) {
                $response = 'oops, theres a problem with your php';
                return $response;
            }else{
                $response = 'Thanks for getting in touch. Ill get back to you as soon as humanly possible.';
                return $response;
            }
        }

    }
}