<?php
// Mock Server Vars
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';
$_SERVER['SERVER_PORT'] = 80;
$_SERVER['HTTP_HOST'] = 'localhost';
$_SERVER['REQUEST_URI'] = '/';

require __DIR__ . '/bootstrap/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

try {
    if (!\Session::isStarted()) {
        \Session::start();
    }
} catch (\Exception $e) {
}
\Session::put('specialPermissions', ['SMS_SENT']);

try {
    $user = \App\User::first();
    if ($user) {
        \Auth::login($user);
    }
} catch (\Exception $e) {
}

function test_render($name, $controller, $method, $id)
{
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
                echo "FAILURE: View Render Error: " . $e->getMessage() . "\n";
                echo $e->getTraceAsString() . "\n";
            }
        } else {
            echo "SUCCESS: Result is not a View (Redirect/String), considered OK: " . gettype($view) . "\n";
        }
    } catch (\Exception $e) {
        echo "FAILURE: Controller Error: " . $e->getMessage() . "\n";
        echo "File: " . $e->getFile() . " Line: " . $e->getLine() . "\n";
        echo $e->getTraceAsString() . "\n";
    }
    echo "---------------------------------------------------\n";
}

$options = getopt("", ["nicuId:", "daycareId:", "opId:", "babyId:"]);
$nicuId = isset($options['nicuId']) ? $options['nicuId'] : 0;
$daycareId = isset($options['daycareId']) ? $options['daycareId'] : 0;
$opId = isset($options['opId']) ? $options['opId'] : 0;
$babyId = isset($options['babyId']) ? $options['babyId'] : 0;

echo "Running verification with IDs: NicuId=$nicuId, DaycareId=$daycareId, OpId=$opId, BabyId=$babyId\n";

if ($nicuId > 0) {
    test_render('NICU Admission', 'App\Http\Controllers\Admission\NicuController', 'edit', $nicuId);
    test_render('NICU Discharge', 'App\Http\Controllers\Admission\NicuController', 'dischargeedit', $nicuId);
}
if ($daycareId > 0) {
    test_render('Daycare', 'App\Http\Controllers\Admission\DaycareController', 'edit', $daycareId);
}
if ($opId > 0) {
    test_render('OP Neonatal', 'App\Http\Controllers\Registration\OpController', 'edit', $opId);
}
if ($babyId > 0) {
    test_render('Neonatal Proforma', 'App\Http\Controllers\Registration\NeonatalController', 'edit', $babyId);
}
?>