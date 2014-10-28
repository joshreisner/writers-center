<?php

class Transaction extends Eloquent {

    protected $fillable = array('amount', 'charge_id', 'paid', 'confirmation', 'type');

    public function user()
    {
        return $this->belongsTo('User');
    }
	
}