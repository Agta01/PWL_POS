<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class PenjualanModel extends Model
{
    use HasFactory;
    protected $table = 't_penjualan';
    protected $primaryKey = 'penjualan_id';
    protected $fillable = ['penjualan_id', 'penjualan_kode', 'penjualan _tanggal', 'pembeli'];
    
    public function m_user(): BelongsTo {
        return $this->belongsTo(UserModel :: class, 'user_id', 'user_id');
    }

    public function detailPenjualan()
    {
        return $this->hasOne(PenjualanDetailModel::class, 'penjualan_id', 'penjualan_id');
    }
}