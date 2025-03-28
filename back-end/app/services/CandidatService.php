<?php 

// app/Services/CandidatService.php
namespace App\Services;

use App\Repositories\CandidatRepository;
use Illuminate\Support\Facades\Storage;

class CandidatService
{
    protected $candidatRepository;

    public function __construct(CandidatRepository $candidatRepository)
    {
        $this->candidatRepository = $candidatRepository;
    }

    public function createCandidat($userId, array $data)
    {
        $candidatData = [
            'type_permis' => $data['type_permis'],
            'id_candidat' => $userId
        ];
        if (isset($data['photo_identite'])) {
            $photoPath = $data['photo_identite']->store('identite', 'public');
            $candidatData['photo_identite'] = $photoPath;
        }

        $existingCandidat = $this->candidatRepository->getCandidat($userId);
        
        if ($existingCandidat) {
            return $this->candidatRepository->updateCandidat($userId, $candidatData);
        }

        return $this->candidatRepository->completeCandidat($candidatData);
    }

    public function getCandidatInfo($userId)
    {
        return $this->candidatRepository->getCandidat($userId);
    }
}