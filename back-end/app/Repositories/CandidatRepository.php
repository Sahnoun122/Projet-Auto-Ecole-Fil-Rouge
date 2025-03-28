<?php 
namespace App\Repositories;

use App\Models\Candidat;
use App\Repositories\CandidatRepositoryInterface;

class CandidatRepository implements CandidatRepositoryInterface
{
    public function completeCandidat( $data)
    {
        return Candidat::create($data);
    }

    public function getCandidat($userId)
    {
        return Candidat::where('id_candidat', $userId)->first();
    }

    public function ModifierCandidat($userId, $data)
    {
        return Candidat::where('id_candidat', $userId)->update($data);
    }
}