<?php
// app/Interfaces/CandidatRepositoryInterface.php
namespace App\Interfaces;

interface CandidatRepositoryInterface
{
    public function completeCandidat( $data);
    public function getCandidat($userId);
    public function updateCandidat($userId, $data);
}