<?php namespace Modules\Atom\Providers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class AtomServiceProvider extends BaseServiceProvider {

    /**
     * Register any application services.
     */
    public function register( ) : void {
        $this -> app -> register( RouteServiceProvider :: class );
        $this -> app -> register( MixinServiceProvider :: class );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot( ) : void {
        $this -> registerConfig           ( ) ;
        $this -> registerMigrations       ( ) ;
        $this -> registerTranslations     ( ) ;
        $this -> registerGraphqlNameSpace ( ) ;
        $this -> registerAliasLoader      ( [ 'Nuwave\\Lighthouse\\Pagination\\PaginateDirective' => 'Modules\\Atom\\GraphQL\\Replace\\PaginateDirective' ] ) ;
        Validator::resolver               ( fn( $translator , $data , $rules , $message ) => new \Modules\Atom\Validation\Validator( $translator , $data , $rules , $message ) );
        $this -> app -> singleton         ( 'DatabaseSeeder' , \Modules\Atom\Database\Seeders\DatabaseSeeder :: class ) ;
        $this -> prependMiddlewares       ( [
            // \Modules\Atom\Http\Middleware\TrustHosts::class ,
            // \Modules\Atom\Http\Middleware\TrustProxies                     :: class ,
            \Modules\Atom\Http\Middleware\PreventRequestsDuringMaintenance :: class ,
            \Modules\Atom\Http\Middleware\TrimStrings                      :: class ,
            \Modules\Atom\Http\Middleware\Localization                     :: class ,
            \Modules\Atom\Http\Middleware\ForceJsonResponse                :: class ,
        ] );
        $this -> registerLighthouseSchema ( [
            new \GraphQL\Type\Definition\PhpEnumType( \Modules\Atom\Enums\Contact\Type  :: class , 'ContactType'  ) ,
            new \GraphQL\Type\Definition\PhpEnumType( \Modules\Atom\Enums\Contact\Key   :: class , 'ContactKey'   ) ,
            new \GraphQL\Type\Definition\PhpEnumType( \Modules\Atom\Enums\Document\Type :: class , 'DocumentType' ) ,
            new \GraphQL\Type\Definition\PhpEnumType( \Modules\Atom\Enums\Document\Key  :: class , 'DocumentKey'  ) ,
        ] ) ;
    }

}