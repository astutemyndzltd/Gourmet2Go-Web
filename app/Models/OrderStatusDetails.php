<?php 

namespace App\Models;
use Eloquent as Model;

class OrderStatusDetails extends Model 
{   
    public $table = 'order_status_details';
    const CREATED_AT = null;
    

    public $fillable = [
        'order_id',
        'order_status_id',
        'lasts_for',
    ];

    protected $casts = [
        'order_id' => 'integer',
        'order_status_id' => 'integer',
        'lasts_for' => 'integer',
        'updated_at' => 'timestamp'
    ];

    public function order() 
    {
        return $this->belongsTo(\App\Models\Order::class);
    }
    
}

?>
