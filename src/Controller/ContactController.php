<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\String\Slugger\SluggerInterface;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="app_contact")
     */
    public function index(Request $request, SluggerInterface $slugger, MailerInterface $mailer): Response
    {
        $contactForm = $this->createForm(ContactType::class);
        $contactForm->handleRequest($request);

        if ($contactForm->isSubmitted() && $contactForm->isValid()) {

            if (empty($contactForm['honeypot']->getData())) { //Filtre les bots


                $contact = $contactForm->getData(); //recup infos formulaire
                $email = (new TemplatedEmail()) //prépare un email via template twigù
                    ->from(new Address($contact['email'])) //expéditeur
                    ->to(new Address('mohamedfabrice.pro@gmail.com')) //destinataire
                    ->replyTo(new Address($contact['email']))
                    ->subject($contact['sujet'])
                    ->htmlTemplate('email/contact_email.html.twig')
                    ->context([
                        'emailAdresse' => $contact['email'],
                        'sujet' => $contact['sujet'],
                        'message' => $contact['message']

                    ]);

                if ($contact['fichier'] !== null) {
                    $originalFilename = pathinfo($contact['fichier']->getClientOriginalName(), PATHINFO_FILENAME); // récupération du nom original du fichier
                    $safeFilename = $slugger->slug($originalFilename); // Transformation caractère spéciaux en caratère basique
                    $newFileName = $safeFilename . '.' . $contact['fichier']->guessExtension(); //renomme fichier pour ajouter extension
                    $email->attachFromPath($contact['fichier']->getPathName(), $newFileName); // attache le fichier en piece jointe

                }
                $mailer->send($email);
                $this->addFlash('success', 'Votre message a bien été envoyer');
                return $this->redirectToRoute('app_contact');
            } else {
                dd('Tu es un bot');
            }
        }
        return $this->render('contact/index.html.twig', [
            'contactForm' => $contactForm->createView(),
        ]);
    }
}
