<?php


namespace App\Subscriber;

use App\Entity\Program;
use App\Entity\Workshop;
use App\Entity\Gallery;
use App\Entity\Category;
use App\Service\ImagesService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

class PostImageSubscriber implements EventSubscriberInterface
{
  private $imagesService;

  public function __construct(ImagesService $imagesService)
  {
    $this->imagesService = $imagesService;
  }

  public static function getSubscribedEvents()
  {
    return array(
      'easy_admin.pre_persist' => array('createImage'),
      'easy_admin.pre_update' => array('editImage'),
    );
  }

<<<<<<< HEAD
  function createImage(GenericEvent $event) {
    $result = $event->getSubject();
    $method = $event->getArgument('request')->getMethod();

//    if ((! $result instanceof Program && ! $result instanceof Workshop && ! $result instanceof Gallery && ! $result instanceof Category) || $method !== Request::METHOD_POST) {
//      return;
//    }
    if (( ! $result instanceof Gallery && ! $result instanceof Category) || $method !== Request::METHOD_POST) {
      return;
    }
=======
        if ((! $result instanceof Program && ! $result instanceof Workshop && ! $result instanceof Gallery && ! $result instanceof Category) || $method !== Request::METHOD_POST) {
            return;
        }
>>>>>>> ed40e5f091c93102c45f30dd492269ce2cfc18bc

    if ($result->getImage() instanceof UploadedFile) {
      $url = $this->imagesService->saveToDisk($result->getImage());
      $result->setImage($url);
    }
  }

  function editImage(GenericEvent $event) {
    $result = $event->getSubject();
    $method = $event->getArgument('request')->getMethod();

<<<<<<< HEAD
//    if ((! $result instanceof Program && ! $result instanceof Workshop && ! $result instanceof Gallery && ! $result instanceof Category) || $method !== Request::METHOD_POST) {
//      return;
//    }
    if (( ! $result instanceof Gallery && ! $result instanceof Category) || $method !== Request::METHOD_POST) {
      return;
    }
    if ($result->getImage() instanceof UploadedFile) {
      $url = $this->imagesService->saveToDisk($result->getImage());
      $result->setImage($url);
=======
        if ((! $result instanceof Program && ! $result instanceof Workshop && ! $result instanceof Gallery && ! $result instanceof Category) || $method !== Request::METHOD_POST) {
            return;
        }
        if ($result->getImage() instanceof UploadedFile) {
            $url = $this->imagesService->saveToDisk($result->getImage());
            $result->setImage($url);
        }
>>>>>>> ed40e5f091c93102c45f30dd492269ce2cfc18bc
    }
  }
}