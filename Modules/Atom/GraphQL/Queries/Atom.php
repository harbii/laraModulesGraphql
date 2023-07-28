<?php namespace Modules\Atom\GraphQL\Queries;
use Illuminate\Http\Resources\Json\JsonResource;
class Atom {
    use \Modules\Atom\GraphQL\Services\Result  ; 
    function namespaces ( $_ , Array $Arguments = [ ] ) : JsonResource {
        return $this -> Successful ( \Illuminate\Support\Facades\Config::get( 'lighthouse.namespaces' ) ) ;
    }
}
