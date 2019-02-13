<?php

namespace VinylStore\Entity;

use Symfony\Component\Validator\Constraints\Date;

class ReleaseEntity implements EntityInterface
{
    /** @var string */
    private $catalogueNumber;

    /** @var string */
    private $title;

    /** @var string */
    private $artist;

    /** @var string */
    private $format;

    /** @var string */
    private $label;

    /** @var Date */
    private $releasedOn;

    /** @var Date */
    private $dateAdded;

    /** @var string */
    private $mediaCondition;

    /** @var string */
    private $sleeveCondition;

    /** @var string */
    private $notes;

    /** @var string */
    private $genre;

    /** @var int */
    private $quantity;

    /** @var int */
    private $barcode;


    /** @inheritdoc */
    public function getName()
    {
        return 'ReleaseEntity';
    }

    /**
     * @return string
     */
    public function getCatalogueNumber(): string
    {
        return $this->catalogueNumber;
    }

    /**
     * @param string $catalogueNumber
     */
    public function setCatalogueNumber(string $catalogueNumber)
    {
        $this->catalogueNumber = $catalogueNumber;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getArtist(): string
    {
        return $this->artist;
    }

    /**
     * @param string $artist
     */
    public function setArtist(string $artist)
    {
        $this->artist = $artist;
    }

    /**
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * @param string $format
     */
    public function setFormat(string $format)
    {
        $this->format = $format;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel(string $label)
    {
        $this->label = $label;
    }

    /**
     * @return Date
     */
    public function getReleasedOn(): Date
    {
        return $this->releasedOn;
    }

    /**
     * @param Date $releasedOn
     */
    public function setReleasedOn(Date $releasedOn)
    {
        $this->releasedOn = $releasedOn;
    }

    /**
     * @return Date
     */
    public function getDateAdded(): Date
    {
        return $this->dateAdded;
    }

    /**
     * @param Date $dateAdded
     */
    public function setDateAdded(Date $dateAdded)
    {
        $this->dateAdded = $dateAdded;
    }

    /**
     * @return string
     */
    public function getMediaCondition(): string
    {
        return $this->mediaCondition;
    }

    /**
     * @param string $mediaCondition
     */
    public function setMediaCondition(string $mediaCondition)
    {
        $this->mediaCondition = $mediaCondition;
    }

    /**
     * @return string
     */
    public function getSleeveCondition(): string
    {
        return $this->sleeveCondition;
    }

    /**
     * @param string $sleeveCondition
     */
    public function setSleeveCondition(string $sleeveCondition)
    {
        $this->sleeveCondition = $sleeveCondition;
    }

    /**
     * @return string
     */
    public function getNotes(): string
    {
        return $this->notes;
    }

    /**
     * @param string $notes
     */
    public function setNotes(string $notes)
    {
        $this->notes = $notes;
    }

    /**
     * @return string
     */
    public function getGenre(): string
    {
        return $this->genre;
    }

    /**
     * @param string $genre
     */
    public function setGenre(string $genre)
    {
        $this->genre = $genre;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity(int $quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @return int
     */
    public function getBarcode(): int
    {
        return $this->barcode;
    }

    /**
     * @param int $barcode
     */
    public function setBarcode(int $barcode)
    {
        $this->barcode = $barcode;
    }
}
