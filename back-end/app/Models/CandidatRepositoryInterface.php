<?php

namespace App\Interfaces;

interface CandidatRepositoryInterface
{
    public function createCandidat( $data);
    public function getCandidatByUserId($userId);
    public function updateCandidat($userId, $data);
}