<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'montant',
        'montant_total',
        'methode',
        'status',
        'date_paiement',
        'reference',
        'description',
        'admin_id',
        'preuve_paiement',
        'est_partiel'
    ];

    protected $casts = [
        'date_paiement' => 'datetime',
        'est_partiel' => 'boolean'
    ];

    public function candidat()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    // Méthodes utilitaires
    public function isCompleted()
    {
        return $this->status === 'complet';
    }

    public function isPending()
    {
        return $this->status === 'en_attente';
    }

    public function isRejected()
    {
        return $this->status === 'rejeté';
    }

    public function isPartial()
    {
        return $this->status === 'partiel';
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'complet' => 'bg-green-100 text-green-800',
            'en_attente' => 'bg-yellow-100 text-yellow-800',
            'rejeté' => 'bg-red-100 text-red-800',
            'partiel' => 'bg-blue-100 text-blue-800',
        ];

        return '<span class="px-2 py-1 text-xs font-semibold rounded-full ' . 
               ($badges[$this->status] ?? 'bg-gray-100 text-gray-800') . '">' .
               ucfirst(str_replace('_', ' ', $this->status)) . '</span>';
    }

    public function getMontantRestantAttribute()
    {
        if ($this->montant_total) {
            $totalPaye = self::where('user_id', $this->user_id)
                ->whereIn('status', ['complet', 'partiel'])
                ->sum('montant');

            return max(0, $this->montant_total - $totalPaye);
        }
        return 0;
    }
}