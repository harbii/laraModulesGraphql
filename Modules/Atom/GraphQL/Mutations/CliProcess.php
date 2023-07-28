<?php namespace Modules\Atom\GraphQL\Mutations;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

use Illuminate\Http\Resources\Json\JsonResource ;

class CliProcess {

    use \Modules\Atom\GraphQL\Services\Result;

    public function optimizeClear( mixed $_ , array $Arguments ) : JsonResource {
        try {
            return $this -> Successful( [ ] , $this -> Process( [ 'php' , 'artisan' , 'optimize:clear' ] ) ) ;
        } catch ( ProcessFailedException $exception ) {
            return $this -> Successful( [ ] , $exception -> getMessage( ) ) ;
        }
    }

    public function lighthouseClear( mixed $_ , array $Arguments ) : JsonResource {
        try {
            return $this -> Successful( [ ] , $this -> Process( [ 'php' , 'artisan' , 'lighthouse:cache' ] ) ) ;
        } catch ( ProcessFailedException $exception ) {
            return $this -> Successful( [ ] , $exception -> getMessage( ) ) ;
        }
    }

    /* public function passport( mixed $_ , array $Arguments ) : JsonResource {
        try {
            $PassportClient = \Modules\Authentication\Models\Passport\Client::where( 'provider' , $Arguments[ 'provider' ] -> name ) -> exists( );
            if ( $PassportClient ) return $this -> Successful( [ ] , $Arguments[ 'provider' ] -> name . ' provider is exists' ) ;
            return $this -> Successful( [ ] , $this -> Process( [ 'php' , 'artisan' , 'passport:client' , '--password' , '--name' , 'Laravel-Password-Grant-Client' , '--provider' , $Arguments[ 'provider' ] -> name ] ) ) ;
        } catch ( ProcessFailedException $exception ) {
            return $this -> Successful( [ ] , $exception -> getMessage( ) ) ;
        }
    } */

    public function Process( Array $Arguments ) : string {
        $migration = new Process( $Arguments );
        $migration -> setWorkingDirectory( base_path( ) );
        $migration -> run( );
        if( $migration -> isSuccessful( ) ){
            return $migration -> getOutput( ) ;
        } else {
            throw new ProcessFailedException( $migration ) ;
        }
    }

    public function Test( mixed $_ , array $Arguments ) : JsonResource {
        $this -> ErrorsWhen( true , 'asdasdasd.' ) ;
        return $this -> Successful( ) ;
    }

}
