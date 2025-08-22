<?php
// src/OC/PlatformBundle/Entity/Image
namespace Viweb\ArticleBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
/**
 * @ORM\Table(name="article_photo")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Photo
{
  /**
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;
  /**
   * @ORM\Column(name="url", type="string", length=255)
   */
  private $url;
  /**
   * @ORM\Column(name="alt", type="string", length=255)
   */
  private $alt;
  /**
   * @var UploadedFile
   */
  private $file;
  
 // On ajoute cet attribut pour y stocker le nom du fichier temporairement
  private $tempFilename;
  /**
   * @ORM\PrePersist()
   * @ORM\PreUpdate()
   */
  public function preUpload()
  {
    // Si jamais il n'y a pas de fichier (champ facultatif), on ne fait rien
    if (null === $this->file) {
      return;
    }
    // Le nom du fichier est son id, on doit juste stocker également son extension
    // Pour faire propre, on devrait renommer cet attribut en « extension », plutôt que « url »
    $this->url = $this->file->guessExtension();
    // Et on génère l'attribut alt de la balise <img>, à la valeur du nom du fichier sur le PC de l'internaute
    $this->alt = $this->file->getClientOriginalName();
  }
  /**
   * @ORM\PostPersist()
   * @ORM\PostUpdate()
   */
  public function upload()
  {
    // Si jamais il n'y a pas de fichier (champ facultatif), on ne fait rien
    if (null === $this->file) {
      return;
    }
    // Si on avait un ancien fichier (attribut tempFilename non null), on le supprime
    if (null !== $this->tempFilename) {
      $oldFile = $this->getUploadRootDir().'/'.$this->id.'.'.$this->tempFilename;
      if (file_exists($oldFile)) {
        unlink($oldFile);
      }
    }
    // On déplace le fichier envoyé dans le répertoire de notre choix
    $this->file->move(
      $this->getUploadRootDir(), // Le répertoire de destination
      $this->id.'.'.$this->url   // Le nom du fichier à créer, ici « id.extension »
    );

    $file_up = $this->getUploadRootDir().'/'.$this->id.'.'.$this->url;
    $file_mini = $this->getUploadRootDir().'/mini/'.$this->id.'.'.$this->url;

    $this->resize_crop_image($file_up, $file_mini, 350 , 233);
  }
  /**
   * @ORM\PreRemove()
   */
  public function preRemoveUpload()
  {
    // On sauvegarde temporairement le nom du fichier, car il dépend de l'id
    $this->tempFilename = $this->getUploadRootDir().'/'.$this->id.'.'.$this->url;
  }
  /**
   * @ORM\PostRemove()
   */
  public function removeUpload()
  {
    // En PostRemove, on n'a pas accès à l'id, on utilise notre nom sauvegardé
    if (file_exists($this->tempFilename)) {
      // On supprime le fichier
      unlink($this->tempFilename);
    }
  }
  
 public function getUploadDir()
  {
    // On retourne le chemin relatif vers l'image pour un navigateur (relatif au répertoire /web donc)
    return 'uploads/photos-articles';
  }
  protected function getUploadRootDir()
  {
    // On retourne le chemin relatif vers l'image pour notre code PHP
    return __DIR__.'/../../../../web/'.$this->getUploadDir();
  }
  public function getWebPath()
  {
    return $this->getUploadDir().'/'.$this->getId().'.'.$this->getUrl();
  }
  /**
   * @return int
   */
  public function getId()
  {
    return $this->id;
  }
  /**
   * @param string $url
   */
  public function setUrl($url)
  {
    $this->url = $url;
  }
  /**
   * @return string
   */
  public function getUrl()
  {
    return $this->url;
  }
  /**
   * @param string $alt
   */
  public function setAlt($alt)
  {
    $this->alt = $alt;
  }
  /**
   * @return string
   */
  public function getAlt()
  {
    return $this->alt;
  }
  /**
   * @return UploadedFile
   */
  public function getFile()
  {
    return $this->file;
  }
  /**
   * @param UploadedFile $file
   */
  // On modifie le setter de File, pour prendre en compte l'upload d'un fichier lorsqu'il en existe déjà un autre
  public function setFile(UploadedFile $file)
  {
    $this->file = $file;
    // On vérifie si on avait déjà un fichier pour cette entité
    if (null !== $this->url) {
      // On sauvegarde l'extension du fichier pour le supprimer plus tard
      $this->tempFilename = $this->url;
      // On réinitialise les valeurs des attributs url et alt
      $this->url = null;
      $this->alt = null;
    }
  }

  function resize_crop_image( $source_file, $dst_dir,$max_width, $max_height,$quality = 80){
      $imgsize = getimagesize($source_file);
      $width = $imgsize[0];
      $height = $imgsize[1];
      $mime = $imgsize['mime'];
   
      switch($mime){
          case 'image/gif':
              $image_create = "imagecreatefromgif";
              $image = "imagegif";
              break;
   
          case 'image/png':
              $image_create = "imagecreatefrompng";
              $image = "imagepng";
              $quality = 7;
              break;
   
          case 'image/jpeg':
              $image_create = "imagecreatefromjpeg";
              $image = "imagejpeg";
              $quality = 80;
              break;
   
          default:
              return false;
              break;
      }
       
      $dst_img = imagecreatetruecolor($max_width, $max_height);
      $src_img = $image_create($source_file);
       
      $width_new = $height * $max_width / $max_height;
      $height_new = $width * $max_height / $max_width;
      //if the new width is greater than the actual width of the image, then the height is too large and the rest cut off, or vice versa
      if($width_new > $width){
          //cut point by height
          $h_point = (($height - $height_new) / 2);
          //copy image
          imagecopyresampled($dst_img, $src_img, 0, 0, 0, $h_point, $max_width, $max_height, $width, $height_new);
      }else{
          //cut point by width
          $w_point = (($width - $width_new) / 2);
          imagecopyresampled($dst_img, $src_img, 0, 0, $w_point, 0, $max_width, $max_height, $width_new, $height);
      }
       
      $image($dst_img, $dst_dir, $quality);
   
      if($dst_img)imagedestroy($dst_img);
      if($src_img)imagedestroy($src_img);
  }
}