<?php

namespace VinylStore\Repository;

interface RepositoryInterface
{
    public function save($data);
    public function findAll();
    public function findOneById($id);
    public function deleteOneById($id);
    public function getCount();
}
