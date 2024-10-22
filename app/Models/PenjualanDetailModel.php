<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PenjualanDetailModel extends Model
{
    use HasFactory;
    protected $table = 't_penjualan_detail';
    protected $primaryKey = 'detail_id';
    protected $fillable = ['penjualan_id', 'harga', 'jumlah'];

    // Relasi ke tabel t_penjualan
    public function penjualan()
    {
        return $this->belongsTo(PenjualanModel::class, 'penjualan_id', 'penjualan_id');
    }
}
