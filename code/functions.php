<?php
function APICall($url, $query) {
	$auth="b5e59f20a9c1aad5435c5854fe3a0fd7";
	$query .= "&authtoken=".$auth;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $query);// Set the request as a POST FIELD for curl.
	$response = curl_exec($ch);
	curl_close($ch);
	return $response;
}


function object_to_array($data)
{
    if (is_array($data) || is_object($data))
    {
        $result = array();
        foreach ($data as $key => $value)
        {
            $result[$key] = object_to_array($value);
        }
        return $result;
    }
    return $data;
}

function uploadAttachementToModule($id, $moduleName = '', $file_path) {
    $auth = "b5e59f20a9c1aad5435c5854fe3a0fd7";
    $file_path = realpath($file_path);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_VERBOSE, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, "https://crm.zoho.com/crm/private/xml/" . $moduleName . "/uploadFile?authtoken=" . $auth . "&scope=crmapi");
    curl_setopt($ch, CURLOPT_POST, true);
    $post = array("id" => $id, "content" => curl_file_create($file_path, 'application/pdf', basename($file_path)));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    $response = curl_exec($ch);

    return $response;
}
?>