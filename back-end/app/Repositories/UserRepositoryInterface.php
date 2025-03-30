<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
    public function all(): Collection;
    public function find( $id);
    public function create( $data);
    public function update( $id, $data);
    public function delete( $id);
    public function getByRole( $role): Collection;
    public function search( $criteria): Collection;
}