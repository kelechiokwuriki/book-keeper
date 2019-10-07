<?php


namespace App\Repositories;


interface RepositoryInterface
{
    public function all();
    public function getCount();
    public function create(array $data);
    public function getById($id);
    public function update(array $data, $id);
    public function delete($id);
    public function where($value, $expected);
}