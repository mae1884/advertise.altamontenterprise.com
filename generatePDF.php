<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
require_once __DIR__ . '/mpdf/vendor/autoload.php';
if (!defined('_MPDF_TTFONTPATH')) {
    // an absolute path is preferred, trailing slash required:
    define('_MPDF_TTFONTPATH', realpath('fonts/'));
    // example using Laravel's resource_path function:
    // define('_MPDF_TTFONTPATH', resource_path('fonts/'));
}

function add_custom_fonts_to_mpdf($mpdf) {

    $fontdata = [
        'sourcesanspro' => [
            'R' => 'HelveticaNeue.ttf'
        ],
    ];

    foreach ($fontdata as $f => $fs) {
        // add to fontdata array
        $mpdf->fontdata[$f] = $fs;

        // add to available fonts array
        foreach (['R', 'B', 'I', 'BI'] as $style) {
            if (isset($fs[$style]) && $fs[$style]) {
                // warning: no suffix for regular style! hours wasted: 2
                $mpdf->available_unifonts[] = $f . trim($style, 'R');
            }
        }

    }

    $mpdf->default_available_fonts = $mpdf->available_unifonts;
}
ob_start();
?>

<style type="text/css">
.ta {width: 150.24px; font-size: 7.5pt; text-indent: 11px; line-height: 7.6pt; font-family: sourcesanspro; height: 500px;text-align: justify;} 
#centrar{position: absolute;
left: 40%;
top: 42%;
-webkit-transform: translate(-50%, -50%);
-ms-transform: translate(-50%, -50%);
transform: translate(-50%, -50%);
    width: 150.24px;
}
</style> 
<div id="centrar">
    <div style="text-align: center;width: 150.24px ;font-family: arial;font-size: 7.5pt;"><b>Legal Notice</b></div>
    <div class="ta"><?= nl2br($leganoticTxtN) ?></div>
</div>
<?php
$output = ob_get_contents();
ob_end_clean();
$mpdf = new \Mpdf\Mpdf();
add_custom_fonts_to_mpdf($mpdf);
$mpdf->WriteHTML($output);
$mpdf->Output($attachFileName, 'F');