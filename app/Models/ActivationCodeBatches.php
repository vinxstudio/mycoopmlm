<?php namespace App\Models;

class ActivationCodeBatches extends AbstractLayer {

	protected $table = 'activation_code_batches';

    function activationCodes(){
        return $this->hasMany($this->namespace.'\ActivationCodes', 'batch_id', 'id');
    }

}
