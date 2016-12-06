<?php

namespace VinylStore\Repository;

interface RepositoryInterface
{
    public function save(array $array);
    public function findAll();
    public function findOneById($id);
    public function deleteOneById($id);
    public function getCount();
}
