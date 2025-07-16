<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class PayslipDetail extends Model
{
    use HasFactory;
    protected $fillable = ['payslip_id', 'component_name', 'component_type', 'amount'];
    public function payslip(): BelongsTo { return $this->belongsTo(Payslip::class); }
}