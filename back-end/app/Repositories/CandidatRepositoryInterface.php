<?php
// app/Interfaces/CandidatRepositoryInterface.php
namespace App\Repositories;

interface CandidatRepositoryInterface
{
    public function completeCandidat( $data);
    public function getCandidat($userId);
    public function ModifierCandidat($userId, $data);
}