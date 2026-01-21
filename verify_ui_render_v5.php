<?php
// Mock Server Vars
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';
$_SERVER['SERVER_PORT'] = 80;
$_SERVER['HTTP_HOST'] = 'localhost';

// Load Laravel environment
require __DIR__.'/bootstrap/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// Mock Session Data
try {
    if (!\Session::isStarted()) {
        \Session::start();
    }
} catch (\Exception $e) {}
\Session::put('specialPermissions', ['SMS_SENT']);

// Mock Authentication (Log in the first user found)
try {
    $user = \App\User::first();
    if ($user) {
        \Auth::login($user);
    }
} catch (\Exception $e) {
    echo "Warning: Could not log in user: " . $e->getMessage() . "\n";
}

// Helper for testing
function test_render($name, $controller, $method, $id) {
    echo "Testing UI Render: $name (ID: $id)...\n";
    try {
        $ctrl = app($controller);
        $enc_id = \SiteHelpers::encrypt_id($id); 
        $request = new \Illuminate\Http\Request();
        
        $view = $ctrl->$method($enc_id, '', $request);
        
        if (is_object($view) && method_exists($view, 'render')) {
             try {
                 $content = $view->render();
                 echo "SUCCESS: Rendered " . strlen($content) . " bytes.\n";
             } catch (\Exception $e) {
                 echo "FAILURE: Render Error: " . $e->getMessage() . "\n";
             }
        } else {
             echo "SUCCESS: Result is not a View (Redirect/String), considered OK: " . gettype($view) . "\n";
        }
    } catch (\Exception $e) {
        echo "FAILURE: Controller Error: " . $e->getMessage() . "\n";
    }
    echo "---------------------------------------------------\n";
}

// IDs (Will be sed-replaced)
$nicuId = 10253; 
$admissionId = 16154; // Discharge needs NicuId usually
$daycareId = 22344;
$opId = 4697;
$babyId = 11364;

// 1. NICU Admission (Edit)
test_render('NICU Admission', 'App\Http\Controllers\Admission\NicuController', 'edit', $nicuId);

// 2. NICU Discharge (Discharge Edit)
test_render('NICU Discharge', 'App\Http\Controllers\Admission\NicuController', 'dischargeedit', $nicuId);

// 3. Daycare
test_render('Daycare', 'App\Http\Controllers\Admission\DaycareController', 'edit', $daycareId);

// 4. OP Neonatal
test_render('OP Neonatal', 'App\Http\Controllers\Registration\OpController', 'edit', $opId);

// 5. Neonatal Proforma
test_render('Neonatal Proforma', 'App\Http\Controllers\Registration\NeonatalController', 'edit', $babyId);
?>
