<?php

namespace App\Controller;

use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MailController extends AbstractController
{
    public function __invoke(Request $request,UserRepository $repository, EntityManagerInterface $manager): JsonResponse
    {
       $token=$request->get('token');
       $user=$repository->findOneBy(["token"=>$token]);
       if (!$user)
           return new JsonResponse(['token'=>'invalid token'],Response::HTTP_BAD_REQUEST);
       if ($user->isIsEnable())
           return new JsonResponse(['message'=>'your account is already actived'],Response::HTTP_BAD_REQUEST);
       if ($user->getExpireAt()<new DateTime())
           return new JsonResponse(['error'=>'invalid token']);
       $user->setIsEnable(1);
       $manager->flush();
       return new JsonResponse(['message'=>'your account is actived by success...'],Response::HTTP_ACCEPTED);
   }
}
