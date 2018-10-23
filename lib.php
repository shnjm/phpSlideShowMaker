<?php

function html2img($string,$name)
{
	$htm="./temp_data/tm_pg.html";
	$page=fopen($htm,"w");
	$code='<html><head><meta http-equiv="content-type" content="text/html;charset=utf-8" /><style>html {border-radius: 25px;border: 2px solid #73AD21;padding: 20px; }</style></head><body>';
	$code=$code.$string."</body></html>";
	fwrite($page,$code);
	fclose($page);
	
	$cmd="xvfb-run --server-args=\"-screen 0, 710x400x24\" ";
	$cmd=$cmd."cutycapt --min-width=710 --min-height=400 --url=file://".realpath($htm)." --out=temp_data/".$name." 2>&1";
	shell_exec($cmd);
	sleep(10);
	return "./temp_data/".$name;
}

function pic_downloader($url,$name)
{
	$dest="./temp_data/".$name;
	copy($url,$dest);
	return "./temp_data/".$name;
}

function rank_maker($rank)
{
	$cmd="convert -size 710x400 -gravity center -font Helvetica caption:".$rank." temp_data/r".$rank.".jpeg";
	shell_exec($cmd);
	sleep(10);
	return "./temp_data/"."r".$rank.".jpeg";
}

function title_maker($input)
{
	$words=explode(" ",$input);
	$new_string="";
	for($i=1;$i<=sizeof($words);$i++)
	{
		$new_string=$new_string.$words[$i-1];
		if(($i%4)==0)
		{
			$new_string=$new_string."\\n";
		}
		else
		{
			$new_string=$new_string." ";
		}
	}
	return $new_string;
}


?>
