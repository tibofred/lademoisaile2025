<?php

namespace Viweb\BaseBundle\EventListener;


use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Viweb\BaseBundle\Entity\Media;

class MediaUploadListener
{

    private $baseDir;

    public function __construct(string $baseDir)
    {
        $this->baseDir = $baseDir;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->upload($entity);
    }

    private function upload($entity, $oldPath = null)
    {
        if (!$entity instanceof Media || !$entity->getPath() instanceof UploadedFile) {
            if ($oldPath) {
                $entity->setPath($oldPath);
            }
            return $entity;
        }
        /**
         * @var UploadedFile $file ;
         */
        $file = $entity->getPath();
        $fileName = md5(uniqid()) . '.' . $file->guessExtension();
        $entity->setFilename($file->getClientOriginalName() . $file->guessExtension());
        $file->move($this->baseDir, $fileName);

        $entity->setPath($this->baseDir . '/' . $fileName);
        $entity->setName($file->getClientOriginalName());

        return $fileName;
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $changes = $args->getEntityChangeSet();
        $path = null;
        if (array_key_exists('path', $changes) && $changes['path'][1] == null) {
            $path = $changes['path'][0];
        }
        $entity = $args->getEntity();

        $this->upload($entity, $path);
    }
}