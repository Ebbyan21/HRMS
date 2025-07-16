<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Payslip extends Model
{
    use HasFactory;
    protected $fillable = ['employee_id', 'pay_period_start', 'pay_period_end', 'gross_salary', 'total_deductions', 'net_salary', 'status'];
    public function employee(): BelongsTo { return $this->belongsTo(Employee::class); }
    public function details(): HasMany { return $this->hasMany(PayslipDetail::class); }
}