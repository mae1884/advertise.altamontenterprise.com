<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/vendor/autoload.php';
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
<style type="text/css"> /* textarea needs a line-height for the javascript to work */ .ta {width: 245px; font-size: 7.5pt; text-indent: 14px; line-height: 7.6pt; font-family: sourcesanspro; height: 500px;} </style> 
<div style="text-align: center;width: 245px;"><b><h4>Legal Notice</h4></b></div>
<div class="ta">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheet</div>
<?php
$output = ob_get_contents();
ob_end_clean();
$mpdf = new \Mpdf\Mpdf('utf-8', 'Letter', 0, '', 0, 0, 0, 0, 0, 0);
add_custom_fonts_to_mpdf($mpdf);
$mpdf->WriteHTML($output);
$mpdf->Output("tmp/phpflow.pdf", 'F');