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
        'date_paiement',
        'description',
        'admin_id'
    ];

    protected $casts = [
        'date_paiement' => 'date',
    ];

    public function candidat()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function getFormattedDateAttribute()
    {
        return $this->date_paiement->format('d/m/Y');
    }

    public function getFormattedMontantAttribute()
    {
        return number_format($this->montant, 2) . ' DH';
    }

    public function getFormattedTotalAttribute()
    {
        return number_format($this->montant_total, 2) . ' DH';
    }

    public function getMontantRestantAttribute()
    {
        $totalPaye = Paiement::where('user_id', $this->user_id)
            ->sum('montant');
            
        return max(0, $this->montant_total - $totalPaye);
    }

    public function getFormattedRestantAttribute()
    {
        return number_format($this->montant_restant, 2) . ' DH';
    }

    public function getPourcentagePayeAttribute()
    {
        if ($this->montant_total == 0) return 0;
        return round(($this->montant / $this->montant_total) * 100, 2);
    }
}