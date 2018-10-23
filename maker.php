<?php
include("status_wr.php");
include("lib.php");

class maker
{
	var $descriptor="video_desc.txt";
	
	function make_desc($input)
	{
		$option=array();
		$option[0]=array("high_quality",1);
		$option[1]=array("subtitle_type","\"render\"");
		$option[2]=array("border",100);
		$option[3]=array("sharpen",1);
		$option[4]=array("widescreen",1);
		$option[5]=array("subtitle_font_size",20);
		$option[6]=array("subtitle_location_x",0);
		$option[7]=array("subtitle_location_y",60);
		$option[8]=array("subtitle_color","\"black\"");
		$option[9]=array("subtitle_outline_color","\"white\"");
		$background="./extra/background.jpeg";
		$audio="./extra/audio.mp3";
		$fadein="fadein:1\n";
		$fadeout="fadeout:1\n";
		$trans="crossfade:1\n";
		
		$in_data=json_decode($input,true);
		$file_desc=fopen($this->descriptor,"w");
		
		for($i=0;$i<sizeof($option);$i++)
		{
			fwrite($file_desc,$option[$i][0]."=".$option[$i][1]."\n");
		}
		
		fwrite($file_desc,realpath($audio).":1\n");
		fwrite($file_desc,"background:0::".realpath($background)."\n");
		fwrite($file_desc,"background:1\n");
		fwrite($file_desc,$fadein);
		fwrite($file_desc,"title:".$in_data["title"]["duration"].":".title_maker($in_data["title"]["text"])."\n");
		fwrite($file_desc,$trans);
		fwrite($file_desc,realpath($in_data["intro"]["img_name"]).":".$in_data["intro"]["duration"]."\n");
		fwrite($file_desc,$trans);
		
		for($i=(sizeof($in_data["book"])-1);$i>=0;$i--)
		{
			fwrite($file_desc,realpath($in_data["book"][$i]["rank_img"]).":2\n");
			fwrite($file_desc,$trans);
			fwrite($file_desc,realpath($in_data["book"][$i]["image"]["img_name"]).":".$in_data["book"][$i]["image"]["duration"].":".$in_data["book"][$i]["image"]["name"].":\n");
			fwrite($file_desc,$trans);
			fwrite($file_desc,realpath($in_data["book"][$i]["details"]["img_name"]).":".$in_data["book"][$i]["details"]["duration"]."\n");
			fwrite($file_desc,$trans);
		}
		
		fwrite($file_desc,realpath($in_data["conclution"]["img_name"]).":".$in_data["conclution"]["duration"]."\n");
		fwrite($file_desc,$fadeout);
		fwrite($file_desc,"exit\n");
		fclose($file_desc);
		
		return true;
		
	}
	
	function make_ready($input)
	{
		$old_data=json_decode($input,true);
		$new_data=array();
		$new_data["title"]["text"]=str_replace(":","\:",$old_data["title"]["text"]);
		$new_data["title"]["duration"]=$old_data["title"]["duration"];
		$new_data["intro"]["img_name"]=html2img($old_data["intro"]["text"],"intro.png");
		$new_data["intro"]["duration"]=$old_data["intro"]["duration"];
		
		for($i=0;$i<sizeof($old_data["book"]);$i++)
		{
			$new_data["book"][$i]["rank_img"]=rank_maker($i+1);
			$new_data["book"][$i]["details"]["img_name"]=html2img($old_data["book"][$i]["details"]["text"],"t".($i+1).".png");
			$new_data["book"][$i]["details"]["duration"]=$old_data["book"][$i]["details"]["duration"];
			
			$new_data["book"][$i]["image"]["img_name"]=pic_downloader($old_data["book"][$i]["image"]["link"],"i".($i+1).".jpeg");
			$new_data["book"][$i]["image"]["duration"]=$old_data["book"][$i]["image"]["duration"];
			$new_data["book"][$i]["image"]["name"]=str_replace(":","\:",$old_data["book"][$i]["image"]["name"]);
			
		}
		
		$new_data["conclution"]["img_name"]=html2img($old_data["conclution"]["text"],"conc.png");
		$new_data["conclution"]["duration"]=$old_data["conclution"]["duration"];
		if(isset($old_data["background"]))
		{
			$new_data["background"]=pic_downloader($old_data["background"],"back.jpeg");
		}
		
		return json_encode($new_data);
		
	}
	
	function make_video($flag)
	{
		if(!$flag)
		{
			exit(0);
		}
		//$name="video_".rand(100,100000);
		$name="testing";
		shell_exec("dvd-slideshow -n '".$name."' -f video_desc.txt -mp4 -s 1920x1080");
		return $name.".mp4";
		
	}
	
	
}



?>
