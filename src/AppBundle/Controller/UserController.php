<?php

    namespace AppBundle\Controller;

    use AppBundle\Form\UserType;
    use AppBundle\Service\FileUploader;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use FOS\RestBundle\Controller\Annotations as Rest;
    use FOS\RestBundle\Controller\FOSRestController;
    use Symfony\Component\HttpFoundation\JsonResponse;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use FOS\RestBundle\View\View;
    use AppBundle\Entity\User;

    class UserController extends FOSRestController
    {
        /**
         * @Rest\Get("/users")
         */
        public function getAction()
        {
            $restresult = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();
            if ($restresult === null) {
                return new View("there are no users exist", Response::HTTP_NOT_FOUND);
            }
            return $restresult;
        }

        /**
         * @Rest\Post("/user/")
         *
         */
        public function postAction(Request $request, FileUploader $fileUploader)
        {
            $data = new User;
            $form = $this->createForm(UserType::class, $data);
            $form->submit($request->request->all());
            $data->setPicture($request->files->get('picture'));

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $file = $data->getPicture();
                $fileName = $fileUploader->upload($file);
                $data->setPicture($fileName);

                $em->persist($data);
                $em->flush();

                return $data;

            } else {
                return $form;
            }
        }

        /**
         * @Rest\Get("/mail")
         */
        public function mailAction(Request $request)
        {
            $email = $request->get('email');
            $singleresult = $this->getDoctrine()->getRepository('AppBundle:User')->findOneByEmail($email);
            if ($singleresult === null) {
                return new  JsonResponse(false);
            }
            return new JsonResponse(true);
        }


        /**
         * @Rest\Put("/user/{id}")
         */
        public function updateAction(Request $request){
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('AppBundle:User')->findOneById($request->get('id'));


            if (empty($user)) {
                return new JsonResponse(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
            }

            $form = $this->createForm(UserType::class, $user);

            $form->submit($request->request->all(), false);

            if ($form->isValid()) {
                $em->flush();
                return $user;
            } else {
                return $form;
            }
        }

        /**
         * Set score
         *
         * @Rest\Put("/user/{id_user}/vote/{id_target}")
         */
        public function voteAction($id_user, $id_target, Request $request)
        {
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('AppBundle:User')->findOneById($id_user);
            $targetUser = $em->getRepository('AppBundle:User')->findOneById($id_target);
            /*$user->setScore($user->getScore()+1);*/


            if ($user->getVoted(true)) {
                return 'Vous avez déjà voté !';

            } elseif ($targetUser->setScore($targetUser->getScore() + 1) && ($user->setVoted(true))){

                $em->flush();
                return $targetUser->getScore();
            }


        }

        /**
         * @Rest\Put("/user/{id}")
         */
        /* public function updateAction($id,Request $request)
         {
             $data = new User;
             $firstName = $request->get('first_name');
             $lastName = $request->get('last_name');
             $email = $request->get('email');
             $sn = $this->getDoctrine()->getManager();
             $user = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);
             if (empty($user)) {
                 return new View("User not found", Response::HTTP_NOT_FOUND);

             } elseif (!empty($lastName) && !empty($firstName) && !empty($email)) {
                 $user->setFirstName($firstName);
                 $user->setLastName($lastName);
                 $user->setEmail($email);
                 $sn->flush();
                 return new View("User Updated Successfully", Response::HTTP_OK);
             }

             elseif(!empty($firstName) && !empty($lastName) && empty($email)){
                 $user->setFirstName($firstName);
                 $user->setLastName($lastName);
                 $sn->flush();
                 return new View("User Updated Successfully", Response::HTTP_OK);
             }

             elseif(!empty($firstName) && empty($lastName) && !empty($email)){
                 $user->setFirstName($firstName);
                 $user->setEmail($email);
                 $sn->flush();
                 return new View("User Updated Successfully", Response::HTTP_OK);
             }

             elseif(empty($firstName) && !empty($lastName) && !empty($email)){
                 $user->setLastName($lastName);
                 $user->setEmail($email);
                 $sn->flush();
                 return new View("User Updated Successfully", Response::HTTP_OK);
             }

             elseif((empty($lastName) && !empty($firstName)) || (!empty($lastName) && empty($firstName))){
                 $user->setFirstName($firstName) || $user->setLastName($lastName);
                 $sn->flush();
                 return new View("User Updated Successfully", Response::HTTP_OK);
             }

             elseif((empty($lastName) && !empty($email)) || (!empty($lastName) && empty($email))){
                 $user->setEmail($email) || $user->setLastName($lastName);
                 $sn->flush();
                 return new View("User Updated Successfully", Response::HTTP_OK);
             }

             elseif((empty($firstName) && !empty($email)) || (!empty($firstName) && empty($email))){
                 $user->setEmail($email) || $user->setFirstName($firstName);
                 $sn->flush();
                 return new View("User Updated Successfully", Response::HTTP_OK);
             }
         }*/
    }