<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'get-patient-details',
        'get-machine-status',
        'get-lab-details',
        'synchronize-doctors-master',
        'synchronize-department-master',
        'synchronize-Investigation-master',
        'get-prescription',
        'fhir-json-post',
        'prescription-instant-status',
        'prescription-stop-status',
        'check-user-login',
        'dsn-status-data',
        'get-dashboard-event',
        'post-lab-culture-details',
        'post-page-data',
        'transfer-patient-in-hms',
        'post-pacs-data',
        'range-data-post',
        'ventilator-temp-process',
        'get-nicu-inpatient-list',
        'store-daycare-transcribed-data',
        'store-neonatal-proforma-transcribed-data',
        'store-daycare-proforma-transcribed-data',
        'store-nicu-admission-transcribed-data',
        'store-nicu-discharge-transcribed-data',
        'store-op-neonatal-transcribed-data'
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        return parent::handle($request, $next);
    }

}
