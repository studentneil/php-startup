<?php

namespace VinylStore\Entity;

class ReleaseEntity
{
    /** @var int */
    private $id;

    /** @var string */
    private $artist;

    /** @var string */
    private $title;

    /** @var string */
    private $catalogNumber;

    /** @var string */
    private $label;

    /** @var string */
    private $format;

    /** @var \DateTime */
    private $released;

    /** @var \DateTime*/
    private $added;

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

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
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
    public function setArtist(string $artist): void
    {
        $this->artist = $artist;
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
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getCatalogNumber(): string
    {
        return $this->catalogNumber;
    }

    /**
     * @param string $catalogNumber
     */
    public function setCatalogNumber(string $catalogNumber): void
    {
        $this->catalogNumber = $catalogNumber;
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
    public function setLabel(string $label): void
    {
        $this->label = $label;
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
    public function setFormat(string $format): void
    {
        $this->format = $format;
    }

    /**
     * @return \DateTime
     */
    public function getReleased(): \DateTime
    {
        return $this->released;
    }

    /**
     * @param \DateTime $released
     */
    public function setReleased(\DateTime $released): void
    {
        $this->released = $released;
    }

    /**
     * @return \DateTime
     */
    public function getAdded(): \DateTime
    {
        return $this->added;
    }

    /**
     * @param \DateTime $added
     */
    public function setAdded(\DateTime $added): void
    {
        $this->added = $added;
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
    public function setMediaCondition(string $mediaCondition): void
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
    public function setSleeveCondition(string $sleeveCondition): void
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
    public function setNotes(string $notes): void
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
    public function setGenre(string $genre): void
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
    public function setQuantity(int $quantity): void
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
    public function setBarcode(int $barcode): void
    {
        $this->barcode = $barcode;
    }
}
