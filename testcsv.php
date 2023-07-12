<?php
$row = 1;
if (($handle = fopen("therapists-uk.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
	    print_r($data);
        $num = count($data);
        $row++;
        for ($c=0; $c < $num; $c++) {
        //    echo $data[$c] . "<br />\n";
        }
	if($row > 1)
		exit;
    }
    fclose($handle);
}
/*
    [0] => Nicole Jasmine Johnson
    [1] => 12/17/18
    [2] => Florida
    [3] => EST
    [4] => Pinellas
    [5] => bluepearltherapyllc@gmail.com
    [6] => Yes
    [7] => Female
    [8] => 65
    [9] => 3/31/23
    [10] => https://mqa-internet.doh.state.fl.us/MQASearchServices/HealthCareProviders/LicenseVerification?LicInd=12388&ProCde=5201&org=%20
    [11] => 7/4/21
    */
