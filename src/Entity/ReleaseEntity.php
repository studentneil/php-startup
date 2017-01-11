<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 10/01/2017
 * Time: 00:09.
 */

namespace VinylStore\Entity;

class ReleaseEntity
{
    /**
     * @var
     */
    private $id;

    /**
     * @var
     */
    private $artist;

    /**
     * @var
     */
    private $title;

    /**
     * @var
     */
    private $catalog;

    /**
     * @var
     */
    private $label;

    /**
     * @var
     */
    private $format;

    /**
     * @var
     */
    private $released;

    /**
     * @var
     */
    private $added;

    /**
     * @var
     */
    private $mediaCondition;

    /**
     * @var
     */
    private $sleeveCondition;

    /**
     * @var
     */
    private $notes;

    /**
     * @var
     */
    private $genre;

    /**
     * @var
     */
    private $imageFile;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getArtist()
    {
        return $this->artist;
    }

    /**
     * @param mixed $name
     */
    public function setArtist($artist)
    {
        $this->artist = $artist;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getCatalog()
    {
        return $this->catalog;
    }

    /**
     * @param mixed $catalog
     */
    public function setCatalog($catalog)
    {
        $this->catalog = $catalog;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param mixed $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @return mixed
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @param mixed $format
     */
    public function setFormat($format)
    {
        $this->format = $format;
    }

    /**
     * @return mixed
     */
    public function getReleased()
    {
        return $this->released;
    }

    /**
     * @param mixed $released
     */
    public function setReleased($released)
    {
        $this->released = $released;
    }

    /**
     * @return mixed
     */
    public function getAdded()
    {
        return $this->added;
    }

    /**
     * @param mixed $added
     */
    public function setAdded($added)
    {
        $this->added = $added;
    }

    /**
     * @return mixed
     */
    public function getMediaCondition()
    {
        return $this->mediaCondition;
    }

    /**
     * @param mixed $mediaCondition
     */
    public function setMediaCondition($mediaCondition)
    {
        $this->mediaCondition = $mediaCondition;
    }

    /**
     * @return mixed
     */
    public function getSleeveCondition()
    {
        return $this->sleeveCondition;
    }

    /**
     * @param mixed $sleeveCondition
     */
    public function setSleeveCondition($sleeveCondition)
    {
        $this->sleeveCondition = $sleeveCondition;
    }

    /**
     * @return mixed
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @param mixed $notes
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    }

    /**
     * @return mixed
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * @param mixed $genre
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;
    }

    /**
     * @return mixed
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param mixed $imageFile
     */
    public function setImageFile($imageFile)
    {
        $this->imageFile = $imageFile;
    }
}
