<?php


namespace App\Subscriber;

use App\Entity\Program;
use App\Entity\Workshop;
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

    function createImage(GenericEvent $event) {
        $result = $event->getSubject();
        $method = $event->getArgument('request')->getMethod();

        if (! $result instanceof Category || $method !== Request::METHOD_POST) {
            return;
        }
        //  possibilité de ragouter les image dans program et workshop / champ de table supprimé dans les entity
        //
        //if (! $result instanceof Program || $method !== Request::METHOD_POST) {
        //    return;
        //}
        //if (! $result instanceof Workshop || $method !== Request::METHOD_POST) {
        //    return;
        //}

        if ($result->getImage() instanceof UploadedFile) {
            $url = $this->imagesService->saveToDisk($result->getImage());
            $result->setImage($url);
        }
    }

    function editImage(GenericEvent $event) {
        $result = $event->getSubject();
        $method = $event->getArgument('request')->getMethod();

        if (! $result instanceof Category || $method !== Request::METHOD_POST) {
            return;
        }
        if ($result->getImage() instanceof UploadedFile) {
            $url = $this->imagesService->saveToDisk($result->getImage());
            $result->setImage($url);
        }
    }
}