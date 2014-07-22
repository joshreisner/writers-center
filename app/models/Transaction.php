<?php

class Transaction extends Eloquent {

    protected $fillable = array('amount', 'charge_id', 'paid', 'confirmation');

    public function user()
    {
        return $this->belongsTo('User');
    }
	
}