<?php 

namespace App\Models;
use Eloquent as Model;

class OrderStatusDetails extends Model 
{   
    public $table = 'order_status_details';
    public $timestamps = [ 'updated_at' ];

    public $fillable = [
        'order_id',
        'order_status_id',
        'lasts_for'
    ];

    protected $casts = [
        'order_id' => 'integer',
        'order_status_id' => 'integer',
        'lasts_for' => 'integer'
    ];

    public function order() 
    {
        return $this->belongsTo(\App\Models\Order::class);
    }

}

?>
